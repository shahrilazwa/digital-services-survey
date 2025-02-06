@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey Schema</title>
@endsection

@section('subcontent')
<div class="mt-8 flex items-center">
    <h2 class="intro-y mr-auto text-lg font-medium">Survey Result</h2>
</div>
<div class="intro-y box mt-5 py-10 sm:py-5">
    <div class="intro-y mt-5 flex flex-col items-center border-t border-b border-slate-200/60 py-2 px-10 text-xs dark:border-darkmode-400 sm:flex-row sm:text-sm">
        <div class="mt-5 flex items-center text-slate-600 dark:text-slate-500 sm:ml-auto sm:mt-0">
            Open in new window :
            <x-base.tippy
                class="zoom-in ml-2 flex h-8 w-8 items-center justify-center rounded-full border text-slate-400 dark:border-darkmode-400 sm:h-10 sm:w-10"
                href="{{ route('survey-results.table-view', ['id' => $surveyId]) }}"
                as="a"
                target="_blank"
                content="Open In New Window"
            >
                <x-base.lucide
                    class="h-5 w-5"
                    icon="expand"
                />
            </x-base.tippy>
        </div>
    </div>

    <div id="survey-results-app"
        class="intro-y col-span-12 overflow-visible"
        data-survey-id="{{ $surveyId }}"
        data-survey-schema='@json($surveySchema->schema_json)'
        data-survey-results='@json($surveyResults)'>
    >
        <survey-results-table></survey-results-table>
    </div>
</div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/app.js')
@endPushOnce