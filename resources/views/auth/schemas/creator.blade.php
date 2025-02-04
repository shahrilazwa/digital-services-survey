@extends('../themes/base')

@section('head')
    <title>Survey App</title>
@endsection

@section('content')
    <div id="survey-creator-app" class="container mx-auto mt-10">
        <survey-creator></survey-creator>
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    <script>
        // Share AppData and track survey creator state
        window.AppData = { 
            surveySchema: @json($schema)
        };
    </script>
    @vite('resources/js/app.js')
@endPushOnce