@extends('../themes/base')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Survey App</title>
@endsection

@section('content')
    <div id="survey-form-app">
        <survey-component :survey-data="{{ json_encode(['id' => $survey->id] + $surveyData) }}"></survey-component>
    </div>
@endsection

@pushOnce('scripts')
    @vite('resources/js/app.js')
@endPushOnce
