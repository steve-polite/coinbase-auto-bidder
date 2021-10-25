<?php

namespace App\Http\Middleware;

use App\Models\Settings as ModelSettings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Settings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $settings = ModelSettings::select(['key', 'value'])->get();

        $settings = $settings->keyBy('key');

        if (
            $settings->has('LANGUAGE')
            && in_array($settings['LANGUAGE']->value, config('settings.allowed_languages'))
        ) {
            App::setLocale($settings['LANGUAGE']->value);
        }

        if ($settings->has('DEFAULT_DATETIME_FORMAT')) {
            config(['app.datetime_format' => $settings['DEFAULT_DATETIME_FORMAT']->value]);
        }

        if ($settings->has('DISPLAY_TIMEZONE')) {
            config(['app.display_timezone' => $settings['DISPLAY_TIMEZONE']->value]);
        }

        return $next($request);
    }
}
