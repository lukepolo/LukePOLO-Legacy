<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Setting;

/**
 * Class SettingsController
 * @package App\Http\Controllers
 */
class SettingsController extends Controller
{
    /**
     * Main settings view
     * @return mixed
     */
    public function getIndex()
    {
        return view('settings', ['settings' => Setting::get()]);
    }

    /**
     * Saves the settings
     * @return mixed
     */
    public function postIndex()
    {
        foreach (\Request::except(['_token', '/settings']) as $setting_id => $value) {
            $setting = Setting::find($setting_id);

            if ($setting->data != $value) {
                $setting->data = $value;
                $setting->save();
            }
        }
        \Cache::forget('settings');

        return redirect()->back()->with('success', 'You successfully updated the settings!');
    }
}