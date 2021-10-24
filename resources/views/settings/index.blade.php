@extends('layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col mt-3">
                <h1>{{ $title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-4">
                <form method="post">
                    @csrf

                    @if(isset($settings["LANGUAGE"]))
                    <label for="language-input" class="form-label">{{ __('coinbase.settings.language') }}</label>
                    <select name="language" id="language-input" class="form-control">
                        @foreach ($allowed_languages as $language)
                        <option @if($language == $settings["LANGUAGE"]->value) selected @endif value="{{ $language }}">{{ __('coinbase.settings.languages_list.'.$language) }}</option>
                        @endforeach
                    </select>
                    @endif

                    @if(isset($settings["DEFAULT_DATETIME_FORMAT"]))
                    <label for="default-datetime-format-input" class="form-label mt-4">{{ __('coinbase.settings.default_datetime_format') }}</label>
                    <input type="text" class="form-control" name="default-datetime-format" id="default-datetime-format-input" value="{{ $settings['DEFAULT_DATETIME_FORMAT']->value }}">
                    @endif

                    @if(isset($settings["DISPLAY_TIMEZONE"]))
                    <label for="language-input" class="form-label mt-4">{{ __('coinbase.settings.display_timezone') }}</label>
                    <select name="display-timezone" id="language-input" class="form-control">
                        @foreach ($timezones_list as $timezone_key => $timezone)
                        <option @if($timezone_key == $settings["DISPLAY_TIMEZONE"]->value) selected @endif value="{{ $timezone_key }}">{{ $timezone }}</option>
                        @endforeach
                    </select>
                    @endif

                    <button class="btn btn-primary mt-4" type="submit">{{ __('coinbase.save') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
