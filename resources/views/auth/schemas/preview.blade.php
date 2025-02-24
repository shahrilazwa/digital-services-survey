@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
    <meta name="survey-schema-id" content="{{ $schema->id }}">
    <meta name="survey-schema-data" content="{{ htmlspecialchars(json_encode($schema->schema_json), ENT_QUOTES, 'UTF-8') }}">
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Design Survey Schema</h2>
    </div>

    <div class="intro-y box mt-5 py-10 sm:pb-5 sm:pt-10">
        <!-- BEGIN: Wizard Layout -->
        <div class="relative flex flex-col justify-center px-5 mb-10 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button
                    name="btn-schema-edit" 
                    class="h-10 w-10 rounded-full"
                    :variant="$schema->hasCompletedStep('Schema Details') ? 'success' : 'secondary'"
                    data-redirect="{{ route('schemas.edit', ['schema' => $schema->id]) }}"
                    data-step="Schema Preview"                     
                >
                    1
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button
                    name="btn-schema-edit" 
                    class="h-10 w-10 rounded-full"
                    :variant="$schema->hasCompletedStep('Schema Design') ? 'success' : 'secondary'"
                    data-redirect="{{ route('schemas.createSchema', ['schema' => $schema->id]) }}"
                    data-step="Schema Preview"                     
                >
                    2
                </x-base.button>
                <div class="ml-3 font-medium capitalize lg:mx-auto lg:mt-3 lg:w-32">
                    Design
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button
                    name="btn-schema-team"
                    class="h-10 w-10 rounded-full"
                    :variant="$schema->hasCompletedStep('Schema Team') ? 'success' : 'secondary'"
                    data-redirect="{{ route('schemas.createTeam', ['schema' => $schema->id]) }}"
                    data-step="Schema Preview"
                >
                    3
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Team
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-design"
                    class="h-10 w-10 rounded-full" 
                    variant="primary"
                    data-redirect=""
                    data-step="Schema Preview"     
                >
                    4
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Preview
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-manage"
                    class="h-10 w-10 rounded-full" 
                    :variant="$schema->hasCompletedStep('Schema Manage') ? 'success' : 'secondary'"
                    data-redirect="{{ route('schemas.manage', ['schema' => $schema->id]) }}"
                    data-step="Schema Preview"                
                >
                    5
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Manage
                </div>
            </div>             
        </div>
        <!-- END: Wizard Layout --> 

        <div class="mt-5 border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 sm:px-20">
            <!-- BEGIN: SurveyJS Form Viewer Container -->
            <div id="survey-viewer-app" class="intro-y col-span-12 overflow-auto 3xl:overflow-visible">
                <schema-viewer :schema-data="{{ $schema->schema_json }}"></schema-viewer>
            </div>
            <!-- END: SurveyJS Form Viewer Container -->
        </div>

        <!-- BEGIN: Buttons -->
        <div class="intro-y col-span-12 mt-5 mr-5 flex items-center justify-center sm:justify-end">
            <x-base.button
                class="w-24"
                variant="secondary"
                id="prevButton"
                data-redirect="{{ route('schemas.createTeam', ['schema' => $schema->id]) }}"
                data-step="Schema Preview"
            >
                Previous
            </x-base.button>
            <x-base.button
                id="nextButton"
                class="ml-2 w-24"
                variant="primary"
                data-redirect="{{ route('schemas.manage', ['schema' => $schema->id]) }}"
                data-step="Schema Preview"
            >
                Next
            </x-base.button>
        </div>
        <!-- END: Buttons -->        
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/app.js')
    @vite('resources/js/pages/previewSchema.js')
    <script>
        window.AppData = {
            surveySchema: @json($schema),
        };
    </script>
@endPushOnce