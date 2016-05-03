<?php

namespace App\Models\Mongo;

/**
 * Class Setting
 * @package App\Models\Mongo
 */
class Setting extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

}