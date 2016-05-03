<?php

namespace App\Models\Mongo;

/**
 * Class Technology
 * @package App\Models\Mongo
 */
class Technology extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

}