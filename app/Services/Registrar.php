<?php namespace App\Services;

use App\Models\User;
use App\Models\Mongo\UserProvider;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{

            return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);
    }

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        if(\Settings::get('registration'))
        {
            \Session::flash('success', 'You successfully connected your ' . ucwords($data['provider']) . ' account!');
            $user = User::create([
                'first_name' => $data['first_name'],
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
        }
        else
        {
            throw new HttpResponseException(redirect()->back()->withInput()->withErrors('Registration is Disabled!'));
        }
	}

}
