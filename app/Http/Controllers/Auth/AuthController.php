<?php namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Mongo\UserProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Exception\HttpResponseException;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->redirectTo = action('AdminController@getIndex');

        $this->middleware($this->guestMiddleware(), ['except' => [
                'getLogout',
                'getUsers',
                'getUser',
                'postUpdateUser',
                'getDisableLogin'
            ]
        ]);
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
            $userProvider = UserProvider::with('user')->where('provider_id', $user->id)
                ->where('provider', $provider)
                ->first();

            if (empty($userProvider) === false) {
                \Auth::login($userProvider->user);
            } else {
                $nameParts = explode(' ', $user->getName());
                $firstName = array_shift($nameParts);
                $lastName = array_pop($nameParts);
                $this->create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
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

    /**
     * Creates a user with the provider if supplied with one
     * @param $data
     */
    public function create($data)
    {
        if (\Settings::get('registration')) {

            $user = User::create([
                'first_name' => empty($data['first_name']) === false ? $data['first_name'] : $data['nickname'] . '@' . $data['provider'] . '.com',
                'last_name' => $data['last_name'],
                'profile_img' => $data['profile_img'],
                'email' => empty($data['email']) === false ? $data['email'] : $data['nickname'] . '@' . $data['provider'] . '.com',
                'password' => bcrypt((string)$data['provider_id']),
                'role' => 'guest'
            ]);

            UserProvider::create([
                'user_id' => $user->id,
                'provider_id' => $data['provider_id'],
                'provider' => $data['provider'],
            ]);

            \Auth::login($user);

            \Session::flash('success', 'You successfully connected your ' . ucwords($data['provider']) . ' account!');

        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->withErrors('Registration is Disabled!'));
        }
    }

    /**
     * Shows all the users
     * @return mixed
     */
    public function getUsers()
    {
        $userQuery = new User();

        if(\Request::has('disabled')) {
            $userQuery = $userQuery->withTrashed();
        }
        return view('auth.users.index', [
            'users' => $userQuery->paginate(15)
        ]);
    }

    /**
     * Views the users form
     * @param $userID
     * @return mixed
     */
    public function getUser($userID)
    {
        return view('auth.users.form', [
            'user' => User::findOrFail($userID)
        ]);
    }

    /**
     * Updates a user
     * @param $userID
     * @return mixed
     */
    public function postUpdateUser($userID)
    {
        User::findOrFail($userID)->update(\Request::except('_token'));
        return redirect(action('Auth\AuthController@getUsers'));
    }

    /**
     * Disables a user from being able to login
     * @param $userID
     * @return mixed
     */
    public function getDisableLogin($userID)
    {
        User::findOrFail($userID)->delete();
        return back();
    }
}
