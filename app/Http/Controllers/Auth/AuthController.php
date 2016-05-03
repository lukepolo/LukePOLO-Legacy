<?php namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Mongo\UserProvider;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = action('\App\Http\Controllers\AdminController@getIndex');

        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Starts the login process
     * @param $provider
     * @return mixed
     */
    public function getService($provider)
    {
        if (!\Session::has('login_redirect')) {
            \Session::set('login_redirect', \URL::previous());
        }
        return \Socialize::with($provider)->redirect();
    }

    /**
     * Processes the callback
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCallback($provider)
    {
        try {
            $user = \Socialize::with($provider)->user();
        } catch (\Exception $e) {
            // they pressed cancel
        }

        if (empty($user) === false) {
            $user_provider = UserProvider::with('user')->where('provider_id', '=', $user->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($user_provider) === false) {
                // force login with the user
                \Auth::login($user_provider->user);
            } else {
                $name_parts = explode(' ', $user->getName());
                $first_name = array_shift($name_parts);
                $last_name = array_pop($name_parts);
                $this->registrar->create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'profile_img' => $user->getAvatar(),
                    'email' => $user->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'nickname' => $user->getNickname()
                ]);
            }
        }

        if (\Session::has('login_redirect')) {
            $url = \Session::get('login_redirect');
            \Session::forget('login_redirect');
            return redirect($url);
        } else {
            return \Redirect::back();
        }
    }

    public function create()
    {
        if (\Settings::get('registration')) {
            \Session::flash('success', 'You successfully connected your ' . ucwords($data['provider']) . ' account!');
            $user = User::create([
                'first_name' => empty($data['first_name']) === false ? $data['first_name'] : $data['nickname'] . '@' . $data['provider'] . '.com',
                'last_name' => $data['last_name'],
                'profile_img' => $data['profile_img'],
                'email' => empty($data['email']) === false ? $data['email'] : $data['nickname'] . '@' . $data['provider'] . '.com',
                'password' => bcrypt((string)$data['provider_id']),
                'role' => 'guest'
            ]);

            // create a new service profider for the user
            UserProvider::create([
                'user_id' => $user->id,
                'provider_id' => $data['provider_id'],
                'provider' => $data['provider'],
            ]);

            \Auth::login($user);
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->withErrors('Registration is Disabled!'));
        }
    }
}
