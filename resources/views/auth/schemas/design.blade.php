@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
    <meta name="survey-schema-id" content="{{ $schema->id }}">
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Design Survey Schema</h2>
    </div>

    <div class="intro-y box mt-5 py-10 sm:py-5">
        <!-- BEGIN: Wizard Layout -->
        <div class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button
                    name="btn-schema-edit" 
                    class="h-10 w-10 rounded-full"
                    :variant="$schema->hasCompletedStep('Schema Details') ? 'success' : 'secondary'"
                    data-redirect="{{ route('schemas.edit', ['schema' => $schema->id]) }}"
                    data-step="Schema Design"                     
                >
                    1
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-design"
                    class="h-10 w-10 rounded-full" 
                    variant="primary"
                    data-redirect=""
                    data-step="Schema Design"                    
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
                    data-step="Schema Design"
                >
                    3
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Team
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-preview"
                    class="h-10 w-10 rounded-full" 
                    :variant="$schema->hasCompletedStep('Schema Preview') ? 'success' : 'secondary'"
                    data-redirect=""
                    data-step="Schema Design"                
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
                    data-redirect=""
                    data-step="Schema Design"                
                >
                    5
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Manage
                </div>
            </div>             
        </div>
        <!-- END: Wizard Layout --> 
        
        <div class="intro-y mt-5 flex flex-col items-center border-t border-b border-slate-200/60 py-2 px-10 text-xs dark:border-darkmode-400 sm:flex-row sm:text-sm">
            <div class="mt-5 flex items-center text-slate-600 dark:text-slate-500 sm:ml-auto sm:mt-0">
                Open in new window :
                <x-base.tippy
                    class="zoom-in ml-2 flex h-8 w-8 items-center justify-center rounded-full border text-slate-400 dark:border-darkmode-400 sm:h-10 sm:w-10"
                    href="{{ route('schemas.creator', ['schema' => $schema->id]) }}"
                    as="a"
                    target="_blank"
                    content="Open In New Window"
                    onclick="sessionStorage.setItem('surveyCreatorOpen', 'true')"
                >
                    <x-base.lucide
                        class="h-5 w-5"
                        icon="expand"
                    />
                </x-base.tippy>
            </div>
        </div>

        <!-- BEGIN: SurveyJS Form Builder Container -->
        <div id="survey-creator-container">
            <div id="survey-message" class="hidden text-center">
                <h2 class="text-lg font-medium">Survey Creator Opened in Another Tab</h2>
                <p class="mt-4 text-slate-600 dark:text-slate-400">
                    The survey creator is currently open in a new tab. Please use that tab to edit the survey schema.
                </p>
            </div>

            <div id="survey-creator-app" class="intro-y col-span-12 overflow-auto 3xl:overflow-visible">
                <survey-creator></survey-creator>
            </div>
        </div>
        <!-- END: SurveyJS Form Builder Container -->

        <form class="validate-form">
            @csrf
            <!-- BEGIN: Buttons -->
            <div class="intro-y col-span-12 mt-5 mr-5 flex items-center justify-center sm:justify-end">
                <x-base.button
                    name="btn-schema-previous"
                    class="w-24"
                    variant="secondary"
                    data-redirect="{{ route('schemas.edit', ['schema' => $schema->id]) }}"
                    data-step="Schema Design" 
                    {{-- as="a" 
                    href="{{ route('schemas.edit', ['schema' => $schema->id]) }}" --}}
                >
                    Previous
                </x-base.button>
                <x-base.button
                    name="btn-schema-next"
                    class="ml-2 w-24"
                    variant="primary" 
                    type="submit"
                    data-redirect="{{ route('schemas.createTeam', ['schema' => $schema->id]) }}"
                    data-step="Schema Design"                
                >
                    Next
                </x-base.button>
            </div>
            <!-- END: Buttons -->
        </form>
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/app.js')
    @vite('resources/js/pages/createSchemaDesign.js')
    <script>
        // Share AppData and track survey creator state
        window.AppData = { 
            surveySchema: @json($schema), 
            isCreatorOpen: false // Initial state
        };

        // Add storage listener to handle survey creator state without reload
        window.addEventListener('storage', (event) => {
            if (event.key === 'surveyCreatorOpen') {
                const isOpen = event.newValue === 'true';
                if (window.AppData.isCreatorOpen !== isOpen) {
                    console.log(`Survey creator state changed: isOpen = ${isOpen}`);
                    window.AppData.isCreatorOpen = isOpen;

                    // Update UI or state dynamically instead of reloading
                    if (isOpen) {
                        // Handle when survey creator is opened in a new tab
                        document.getElementById('survey-message').classList.remove('hidden');
                        document.getElementById('survey-creator-app').classList.add('hidden');
                    } else {
                        // Handle when survey creator is closed in the new tab
                        document.getElementById('survey-message').classList.add('hidden');
                        document.getElementById('survey-creator-app').classList.remove('hidden');
                    }
                }
            }
        });
    </script>
@endPushOnce