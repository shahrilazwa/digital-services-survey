@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Add Digital Service</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Add Digital Service</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form method="POST" class="validate-form">
                @csrf
               <!-- BEGIN: Add Digital Service Form -->
               <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Digital Services Information
                        </div>
                        <div class="mt-5">

                            <!-- Name -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Title</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the title of the digital service, using a clear and concise name that reflects its purpose.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="service-title"  
                                            name="service-title" 
                                            type="text" 
                                            placeholder="Enter digital service title" 
                                            required
                                            minlength="5"
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
                                            Provide a detailed and user-friendly explanation of what the digital service offers, 
                                            its primary features, and its target audience.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="service-desc"
                                        name="service-desc"
                                        rows="5"
                                        placeholder="Enter a detailed description of the service"
                                    ></x-base.form-textarea>
                                </div>
                            </x-base.form-inline>

                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <x-base.alert class="bg-info/20 dark:border-darkmode-400 dark:bg-darkmode-400" variant="outline-info" dismissible>
                                        <div class="flex items-center">
                                            <span>
                                                <x-base.lucide class="mr-3 h-6 w-6" icon="info" />
                                            </span>
                                            <span class="text-slate-800 dark:text-slate-500">
                                                Tags help users find related services quickly and provide better search results.                                               
                                            </span>
                                            <x-base.alert.dismiss-button class="dark:text-white">
                                                <x-base.lucide class="h-4 w-4" icon="X" />
                                            </x-base.alert.dismiss-button>
                                        </div>
                                    </x-base.alert>
                                </div>
                            </x-base.form-inline>

                            <!-- Tags -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tags</div>
                                            </div>                                           
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Assign one or more relevant tags to categorize the service.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.tom-select class="w-full" name="tags[]" placeholder="Select tag" multiple required>
                                            @foreach ($tags as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </x-base.tom-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>

                        </div>
                    </div>
                </div>
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button
                        class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52"
                        type="button"
                        href="{{ route('digital-services.index') }}"
                        as="a"                    
                    >
                        Cancel
                    </x-base.button>
                    <x-base.button
                        class="w-full py-3 md:w-52"
                        type="submit"
                        variant="primary"
                    >
                        Save
                    </x-base.button>
                </div>                                 
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
    @vite('resources/js/pages/createService.js')
@endPushOnce