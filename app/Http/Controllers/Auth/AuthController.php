<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Mongo\UserProvider;

class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers;

	public function __construct(Guard $auth, Registrar $registrar)
	{
        parent::__construct();

		$this->auth = $auth;
		$this->registrar = $registrar;

        $this->redirectPath = action('\App\Http\Controllers\AdminController@getIndex');

        $this->auth->logout();

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    public function getService($provider)
    {
        if(!\Session::has('login_redirect'))
        {
            \Session::set('login_redirect', \URL::previous());
        }
        return \Socialize::with($provider)->redirect();
    }
    public function getCallback($provider)
    {
        $user = \Socialize::with($provider)->user();

        if(empty($user) === false)
        {
            $user_provider = UserProvider::with('user')->where('provider_id', '=', $user->id)
                ->where('provider', '=' , $provider)
                ->first();

            if(empty($user_provider) === false)
            {
                // force login with the user
                \Auth::login($user_provider->user);
            }
            else
            {
                $name_parts = explode(' ',  $user->getName());
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

            if(\Session::has('login_redirect'))
            {
                $url = \Session::get('login_redirect');
                \Session::forget('login_redirect');
                return redirect($url);

            }
            else
            {
                return \Redirect::back();
            }

        }
    }

    public function getLogout()
    {
        $this->auth->logout();

        return redirect()->back();
    }
}
