<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Settings
 * @package App\Facades
 */
class Settings extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}
