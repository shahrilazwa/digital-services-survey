@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
    <meta name="publish-survey-id" content="{{ $publish_survey->id }}">
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Publish Survey</h2>
    </div>

    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box mt-5 py-10 sm:py-5">
        <div class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    1
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    2
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Schema
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    3
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Platform
                </div>
            </div>            
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    4
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Service
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    5
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Create Team
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full" variant="primary">
                    6
                </x-base.button>
                <div class="ml-3 text-base font-medium lg:mx-auto lg:mt-3 lg:w-32">
                    Publish Survey
                </div>
            </div>                       
        </div>
    </div>
    <!-- END: Wizard Layout -->

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <!-- BEGIN: Publish Survey Form -->
            <form class="validate-form">
                @csrf
                <input type="hidden" name="survey-id" value="{{ $publish_survey->id }}">
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Publish Survey
                        </div>

                        <div class="mt-5">
                            <!-- Survey Link -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label for="survey-title" class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Survey Link</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Survey hyperlink
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="survey-link"  
                                            name="survey-link" 
                                            type="text" 
                                            placeholder="Survey link"
                                            value="{{ $publish_survey->survey_link }}"
                                            required
                                            readonly 
                                        />

                                        <button 
                                            type="button" 
                                            id="copy-link-btn"
                                            class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Copy Link
                                        </button>                                       
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Publish Survey</div>
                                            <div
                                                class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Set the survey as Active or Closed. If Active, you must provide a Start Date and End Date.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="grid-cols-4 gap-2 sm:grid">
                                        <x-base.form-switch>
                                            <x-base.form-switch.input 
                                                id="survey-status" 
                                                type="checkbox"
                                                checked="{{ $publish_survey->status === 'Published' ? 'checked' : '' }}"
                                            />
                                            <x-base.form-switch.label for="survey-status">
                                                Active
                                            </x-base.form-switch.label>
                                        </x-base.form-switch>
                                    </div>
                                    <x-base.alert dismissible variant="outline-warning" class="mt-5 bg-warning/20 dark:border-darkmode-400 dark:bg-darkmode-400">
                                        <div class="flex items-center">
                                            <span>
                                                <x-base.lucide class="mr-3 h-6 w-6" icon="AlertTriangle" />
                                            </span>
                                            <span class="text-slate-800 dark:text-slate-500">
                                                Active surveys require both Start and End Dates to be accessible by surveyees.
                                            </span>
                                            <x-base.alert.dismiss-button class="dark:text-white">
                                                <x-base.lucide class="h-4 w-4" icon="X" />
                                            </x-base.alert.dismiss-button>
                                        </div>
                                    </x-base.alert> 
                                </div>
                            </x-base.form-inline>                          

                            <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Start Date</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            The date when the survey will be accessible to users.
                                        </div>                                        
                                    </div>
                                </x-base.form-label>
                                <div class="input-form">
                                    <div class="relative w-56">
                                            <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                                <x-base.lucide class="h-4 w-4" icon="Calendar" />
                                            </div>
                                            <x-base.litepicker 
                                                id="start-date" 
                                                name="start-date"
                                                value="{{ $publish_survey->start_date ?? '' }}" 
                                                data-single-mode="true"
                                                class="pl-12"
                                            />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">End Date</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            The date when the survey will no longer be accessible.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="input-form">
                                    <div class="relative w-56">
                                            <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                                <x-base.lucide class="h-4 w-4" icon="Calendar" />
                                            </div>
                                            <x-base.litepicker 
                                                id="end-date" 
                                                name="end-date"
                                                value="{{ $publish_survey->end_date ?? '' }}" 
                                                data-single-mode="true"
                                                class="pl-12"
                                            />
                                    </div>
                                </div>
                            </x-base.form-inline>
                        </div>                        
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button type="button" as="a" href="{{ route('publish-surveys.selectTeam', $publish_survey->id) }}" class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">
                        Previous
                    </x-base.button>
                    <x-base.button type="submit" variant="primary" class="w-full py-3 md:w-52">
                        Next
                    </x-base.button>
                </div>                
            </form>
            <!-- END: Publish Survey Form -->                
        </div>
    </div>
    
    <!-- BEGIN: Failed Notification Content -->
    <x-base.notification class="hidden" id="failed-notification-content">
        <x-base.lucide class="text-danger" icon="XCircle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Registration failed!</div>
            <div class="mt-1 text-slate-500">
                Please check the filled form.
            </div>
        </div>
    </x-base.notification>
    <!-- END: Failed Notification Content -->    
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/publishSurvey.js')
@endPushOnce