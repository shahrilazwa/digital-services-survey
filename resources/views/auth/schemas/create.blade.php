@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Survey Schema</h2>
    </div>

    <div class="intro-y box mt-5 py-10 sm:pb-5 sm:pt-10">
        <!-- BEGIN: Wizard Layout -->
        <div class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-create" 
                    class="h-10 w-10 rounded-full" 
                    variant="primary"
                    data-redirect=""
                    data-step="Schema Details"
                >
                    1
                </x-base.button>
                <div class="ml-3 font-medium capitalize lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-design" 
                    class="h-10 w-10 rounded-full" 
                    variant="secondary"
                    data-redirect="/schemas/create/design"
                    data-step="Schema Details"                    
                >
                    2
                </x-base.button>
                <div class="ml-3 font-normal capitalize text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Design
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button 
                    name="btn-schema-team"
                    class="h-10 w-10 rounded-full"
                    variant="secondary"
                    data-redirect=""
                    data-step="Schema Details"
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
                    variant="secondary"
                    data-redirect=""
                    data-step="Schema Details"
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
                    variant="secondary"
                    data-redirect=""
                    data-step="Schema Details"
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
            <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                Schema Details
            </div>
            <form class="validate-form">
                @csrf
                <!-- BEGIN: Schema Title Input -->
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
                                Enter the title of the survey schema.
                            </div>                                                                      
                        </div>
                    </x-base.form-label>
                    <div class="mt-2 w-full flex-1 xl:mt-0">
                        <div class="input-form">
                            <x-base.form-input
                                id="schema-title"  
                                name="schema-title" 
                                type="text" 
                                placeholder="Schema title"
                                required 
                            />
                        </div>
                    </div>
                </x-base.form-inline>
                <!-- END: Schema Title Input -->

                <!-- BEGIN: Schema Description Input -->
                <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                    <x-base.form-label class="xl:!mr-10 xl:w-64">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Description</div>
                            </div>
                            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                Provide a concise description of the schema, highlighting its purpose and features.
                            </div>
                        </div>
                    </x-base.form-label>
                    <div class="mt-2 w-full flex-1 xl:mt-0">
                        <x-base.form-textarea
                            id="schema-desc"
                            name="schema-desc"
                            rows="5"
                            placeholder="Survey schema description"
                        ></x-base.form-textarea>
                        <x-base.form-help class="text-right">
                            Max character 0/255
                        </x-base.form-help>
                    </div>
                </x-base.form-inline>
                <!-- END: Schema Description Input -->

                <!-- BEGIN: Buttons -->
                <div class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
                    <x-base.button
                        class="w-24"
                        variant="secondary"
                        as="a" 
                        href="{{ route('schemas.index') }}"
                    >
                        Cancel
                    </x-base.button>
                    <x-base.button
                        class="ml-2 w-24"
                        variant="primary"
                        type="submit"
                        data-redirect="/schemas/create/design"
                        data-step="Schema Details"
                    >
                        Next
                    </x-base.button>
                </div>
                <!-- END: Buttons -->
            </form>            
        </div>
    </div>  
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/createSchemaDetails.js')
@endPushOnce