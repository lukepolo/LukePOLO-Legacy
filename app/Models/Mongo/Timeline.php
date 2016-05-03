<?php

namespace App\Models\Mongo;

/**
 * Class Timeline
 * @package App\Models\Mongo
 */
class Timeline extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];
    protected $dates = [
        'start_date',
        'end_date'
    ];

}