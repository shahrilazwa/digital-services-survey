@extends('../themes/base')

@section('head')
    <title>Survey Table View</title>
@endsection

@section('content')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Survey Table View</h2>
    </div>


        <div id="survey-results-app"
            class="intro-y col-span-12 overflow-auto"
            data-survey-id="{{ $surveyId }}"
            data-survey-schema='@json($surveySchema)'
            data-survey-results='@json($surveyResults)'>
            <survey-results-table></survey-results-table>
        </div>

@endsection

@pushOnce('scripts')
    @vite('resources/js/app.js')
@endPushOnce
