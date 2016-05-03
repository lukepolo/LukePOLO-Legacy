<?php

namespace App\Services;

use App\Models\Mongo\Setting as modelSettings;

/**
 * Class Settings
 * @package App\Services
 */
class Settings
{
    static $settings;

    /**
     * // TODO - remember forever
     * Settings constructor setsup all the settings into an array for fast use
     */
    public function __construct()
    {
        static::$settings = \Cache::rememberForever('settings', function () {
            foreach (modelSettings::get() as $setting) {
                $settings[$setting->name] = $setting->data;
            }
            return $settings;
        });
    }

    /**
     * Gets a setting based on the string
     * @param $setting
     * @return mixed
     * @throws \Exception
     */
    public function get($setting)
    {
        if (isset(static::$settings[$setting])) {
            return static::$settings[$setting];
        } else {
            throw new \Exception('Missing "' . $setting . '" Setting');
        }
    }
}
