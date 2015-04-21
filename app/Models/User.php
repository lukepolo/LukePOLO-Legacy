<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Eloquent implements AuthenticatableContract {

	use Authenticatable;
    protected $guarded = ['_id'];
}
