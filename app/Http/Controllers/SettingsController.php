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
        $settings = Settings::all()->keyBy('key');

        if ($request->method() == "POST") {
            if (isset($request["language"])) {
                DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["language"], 'LANGUAGE']);
            }

            if (isset($request["default-datetime-format"])) {
                DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["default-datetime-format"], 'DEFAULT_DATETIME_FORMAT']);
            }

            if (isset($request["display-timezone"])) {
                DB::statement('UPDATE settings SET `value` = ? WHERE `key` = ?', [$request["display-timezone"], 'DISPLAY_TIMEZONE']);
            }

            return redirect()->to(route('settings.index'));
        }

        return view('settings.index', [
            'title' => __('coinbase.settings.title'),
            'settings' => $settings,
            'allowed_languages' => MiddlewareSettings::ALLOWED_LANGUAGES,
            'timezones_list' => config('timezones.timezones_list'),
        ]);
    }
}
