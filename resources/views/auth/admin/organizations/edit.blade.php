@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Organization</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Edit Organization</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form method="POST" class="validate-form">
                @csrf
                @method('PUT')
                <!-- BEGIN: Edit Organization Form -->
                <input type="hidden" name="org-id" value="{{ $organization->id }}">
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Organization Information
                        </div>
                        <div class="mt-5">
                            <!-- Organization Name -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Organization Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the name of the organization, ensuring proper capitalization and spelling.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="org-name"  
                                            name="org-name" 
                                            type="text" 
                                            placeholder="Organization name"
                                            value="{{ old('org-name', $organization->org_name) }}" 
                                            required
                                            minlength="5"
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Organization Abbreviation -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Organization Abbreviation</div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the abbreviation for the organization, without any spaces or special characters.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="org-abb"  
                                            name="org-abb" 
                                            type="text" 
                                            placeholder="Organization abbreviation"
                                            value="{{ old('org-abb', $organization->abbreviation) }}" 
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
                                            Provide a detailed description of the organization.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="org-desc"
                                        name="org-desc"
                                        rows="5"
                                        placeholder="Enter organization description"
                                    >{{ old('org-desc', $organization->description) }}
                                    </x-base.form-textarea>
                                </div>
                            </x-base.form-inline>

                            <!-- Organization Type -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Organization Type</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select the type of organization from the dropdown menu.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-select class="w-full" name="orgTypes[]" placeholder="Select organization type" required>
                                            <option value="" disabled selected hidden>Select organization type</option>
                                            @foreach($orgTypes as $key => $label)
                                                <option value="{{ $key }}" {{ $organization->type == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </x-base.form-select>
                                    </div>
                                </div>
                            </x-base.form-inline>       
                        </div>
                    </div>
                </div>
                <!-- END: Edit Organization Form -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button
                        class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52"
                        type="button"
                        href="{{ route('organizations.index') }}"
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
    @vite('resources/js/pages/editOrganization.js')
@endPushOnce