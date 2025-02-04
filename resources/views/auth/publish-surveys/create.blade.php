@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Publish Survey</title>
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Publish Survey</h2>
    </div>

    <div class="intro-y box mt-5 py-10 sm:py-5">
        <div class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full" variant="primary">
                    1
                </x-base.button>
                <div class="ml-3 text-base font-medium lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    2
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Schema
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    3
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select App
                </div>
            </div>            
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    4
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Service
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    5
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Create Team
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    6
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Publish Survey
                </div>
            </div>                       
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <!-- BEGIN: Create Survey Form -->
            <form class="validate-form">
                @csrf

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Survey Information
                        </div>
                        <div class="mt-5">
                            <!-- Title -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label for="survey-title" class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Title</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the title of the survey to be published.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="survey-title"  
                                            name="survey-title" 
                                            type="text" 
                                            placeholder="Publish Survey title"
                                            required 
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Description -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Description</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide a concise yet comprehensive description of the survey, highlighting its purpose, key features, and intended audience.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="survey-desc"
                                        name="survey-desc"
                                        rows="5"
                                        placeholder="Enter publish survey description"
                                    ></x-base.form-textarea>
                                    <x-base.form-help class="text-right">
                                        Max character 0/255
                                    </x-base.form-help>
                                </div>
                            </x-base.form-inline>                               
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button type="button" as="a" href="{{ route('publish-surveys.index') }}" class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">
                        Cancel
                    </x-base.button>
                    <x-base.button type="submit" variant="primary" class="w-full py-3 md:w-52">
                        Next
                    </x-base.button>
                </div>                
            </form>
            <!-- END: Create Survey Form -->            
        </div>
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/createPublishSurvey.js')
@endPushOnce