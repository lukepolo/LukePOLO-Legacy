<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * Class User
 * @package App\Models
 */
class User extends \Moloquent implements AuthenticatableContract
{
    use Authenticatable;
    protected $guarded = ['_id'];
}
