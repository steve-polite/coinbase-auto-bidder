<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Settings as MiddlewareSettings;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings_list = config('settings.settings_list');

        $current_settings = Settings::all()->keyBy('key');

        if ($request->method() == "POST") {
            if (isset($request["main-currency"])) {
                if (Settings::where('key', 'MAIN_CURRENCY')->exists()) {
                    DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["main-currency"], 'MAIN_CURRENCY']);
                } else {
                    Settings::create([
                        'key' => 'MAIN_CURRENCY',
                        'value' => $request["main-currency"]
                    ]);
                }
            }

            if (isset($request["language"])) {
                if (Settings::where('key', 'LANGUAGE')->exists()) {
                    DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["language"], 'LANGUAGE']);
                } else {
                    Settings::create([
                        'key' => 'LANGUAGE',
                        'value' => $request["language"]
                    ]);
                }
            }

            if (isset($request["default-datetime-format"])) {
                if (Settings::where('key', 'DEFAULT_DATETIME_FORMAT')->exists()) {
                    DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["default-datetime-format"], 'DEFAULT_DATETIME_FORMAT']);
                } else {
                    Settings::create([
                        'key' => 'DEFAULT_DATETIME_FORMAT',
                        'value' => $request["default-datetime-format"]
                    ]);
                }
            }

            if (isset($request["display-timezone"])) {
                if (Settings::where('key', 'DISPLAY_TIMEZONE')->exists()) {
                    DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["display-timezone"], 'DISPLAY_TIMEZONE']);
                } else {
                    Settings::create([
                        'key' => 'DISPLAY_TIMEZONE',
                        'value' => $request["display-timezone"]
                    ]);
                }
            }

            return redirect()->to(route('settings.index'));
        }
        return view('settings.index', [
            'title' => __('coinbase.settings.title'),
            'settings_list' => $settings_list,
            'current_settings' => $current_settings,
            'allowed_languages' => config('settings.allowed_languages'),
            'currencies' => config('settings.currencies'),
            'timezones_list' => config('timezones.timezones_list'),
        ]);
    }
}
