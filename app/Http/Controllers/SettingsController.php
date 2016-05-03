<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Setting;

class SettingsController extends Controller
{
    public function getIndex()
    {
        return view('settings', ['settings' => Setting::get()]);
    }

    public function postIndex()
    {
        foreach (\Request::except(['_token', '/settings']) as $setting_id => $value) {
            $setting = Setting::find($setting_id);

            if ($setting->data != $value) {
                $setting->data = $value;
                $setting->save();
            }
        }
        // Delete the cache
        \Cache::forget('settings');

        return redirect()->back()->with('success', 'You successfully updated the settings!');
    }
}