@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Update Platform</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Update Digital Platform</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form class="validate-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="platform-id" value="{{ $digital_platform->id }}">
                <!-- BEGIN: Add Digital Platform Form -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Update Platform Information
                        </div>
                        <div class="mt-5">
                            <!-- Digital Platform Name -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide the full name of the platform. Ensure it is accurately spelled and capitalized.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="platform-name"  
                                            name="platform-name" 
                                            type="text" 
                                            placeholder="Digital Platform name"
                                            value="{{ $digital_platform->platform_name }}"
                                            required
                                            minlength="5"
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Digital Platform Abbreviation -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Abbreviation</div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter a concise abbreviation for the platform. Avoid using spaces or special characters.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            name="platform-abbr" 
                                            type="text" 
                                            placeholder="Digital Platform abbreviation"
                                            value="{{ $digital_platform->abbreviation }}"
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Digital Platform URL -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">URL</div> 
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>  
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide the URL of the platform. Ensure it begins with 'http://' or 'https://'.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="platform-url"  
                                            name="platform-url" 
                                            type="text" 
                                            placeholder="Digital Platform url"
                                            value="{{ $digital_platform->url }}"
                                            required 
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Digital Platform Type -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Platform Type</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select the type of digital platform from the dropdown list.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-select class="w-full" name="platformTypes[]" value="{{ $digital_platform->type }}" placeholder="Select platform type" required>
                                            <option value="" disabled selected hidden>Select platform type</option>
                                            @foreach($platformTypes as $key => $label)
                                                <option value="{{ $key }}" {{ $digital_platform->type == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach                                         
                                        </x-base.form-select>
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
                                            Provide a concise yet comprehensive description of the digital platform, highlighting its purpose, key features, and intended audience.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="platform-desc"
                                        name="platform-desc"
                                        rows="5"
                                        placeholder="Enter platform description"
                                    >{{ old('platform-desc', $digital_platform->description) }}
                                    </x-base.form-textarea>
                                    <x-base.form-help class="text-right">
                                        Max character 0/255
                                    </x-base.form-help>
                                </div>
                            </x-base.form-inline>
                        </div>
                    </div>
                </div>

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Enterprise Architecture Cluster
                        </div>
                        <div class="mt-5">
                            <!-- EA Cluster -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">EA Cluster</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select the EA cluster to which this digital platform belongs.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-select class="w-full" name="eaClusters[]" value="{{ $digital_platform->ea_cluster }}" placeholder="Select EA Cluster" required>
                                            <option value="" disabled selected hidden>Select EA Cluster</option>
                                            @foreach($eaClusters as $key => $label)
                                                <option value="{{ $key }}" {{ $digital_platform->ea_cluster == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </x-base.form-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>                            
                        </div>                                              
                    </div>
                </div>                            

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Digital Platform Ownership
                        </div>
                        <div class="mt-5">
                            <!-- Digital Platform Owner -->
                            <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Ownership</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>  
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Choose whether the platform is owned by an agency or an organization.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="input-form">
                                    <div class="mt-3 w-full flex-1 xl:mt-0">
                                        <div class="flex flex-col sm:flex-row">
                                            <x-base.form-check class="mr-4">
                                                <x-base.form-check.input
                                                    id="ownerOrg"
                                                    name="owner"
                                                    type="radio"
                                                    value="organization"
                                                    checked="{{ $digital_platform->org_id ? 'checked' : '' }}"
                                                    required
                                                />
                                                <x-base.form-check.label>
                                                    <div>Organization</div>
                                                    <div class="mt-1 w-56 text-xs leading-relaxed text-slate-500">
                                                        Platform is owned and maintained by a state government or ministry.
                                                    </div>
                                                </x-base.form-check.label>
                                            </x-base.form-check>
                                            <x-base.form-check class="mr-4 mt-2 sm:mt-0">
                                                <x-base.form-check.input
                                                    id="ownerAgency"
                                                    name="owner"
                                                    type="radio"
                                                    value="agency"
                                                    checked="{{ $digital_platform->agency_id ? 'checked' : '' }}"
                                                    required
                                                />
                                                <x-base.form-check.label>
                                                    <div>Agency</div>
                                                    <div class="mt-1 w-56 text-xs leading-relaxed text-slate-500">
                                                        Platform is owned and maintained by a statutory body, federal or state agency.
                                                    </div>
                                                </x-base.form-check.label>
                                            </x-base.form-check>
                                        </div>
                                    </div>
                                </div>
                            </x-base.form-inline>
                            <div id="agencyDropdown" class="hidden mt-10">
                                <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                    <x-base.form-label class="xl:!mr-10 xl:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <div class="font-medium">Agency</div>
                                                </div>
                                                <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                    Required
                                                </div>                                            
                                            </div>
                                            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                                Choose the owning agency from the list, if applicable.
                                            </div>
                                        </div>
                                    </x-base.form-label>
                                    <div class="mt-3 w-full flex-1 xl:mt-0">
                                        <div class="input-form">
                                            <x-base.tom-select 
                                                class="form-control" 
                                                name="agency" 
                                                placeholder="Select an agency"
                                                data-header="Instructions: Type to search and select an agency"
                                            >
                                                <option value="">Select an agency</option>
                                                @foreach ($agencies as $id => $name)
                                                    <option value="{{ $id }}" {{ $digital_platform->agency_id == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option> 
                                                @endforeach
                                               
                                            </x-base.tom-select>
                                        </div>
                                    </div>
                                </x-base.form-inline>
                            </div>
                            <div id="orgDropdown" class="hidden mt-10">
                                <x-base.form-inline formInline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                    <x-base.form-label class="xl:!mr-10 xl:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="flex items-center">
                                                    <div class="font-medium">Organization</div>
                                                </div>
                                                <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                    Required
                                                </div>                                            
                                            </div>
                                            <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                                Choose the owning organization from the list, if applicable.
                                            </div>
                                        </div>
                                    </x-base.form-label>
                                    <div class="mt-3 w-full flex-1 xl:mt-0">
                                        <div class="input-form">
                                            <x-base.tom-select 
                                                class="form-control" 
                                                name="organization" 
                                                placeholder="Select an organization"
                                                data-header="Instructions: Type to search and select an organization"
                                            >
                                                <option value="">Select an Organization</option>
                                                @foreach ($organizations as $id => $name)
                                                    <option value="{{ $id }}" {{ $digital_platform->org_id == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </x-base.tom-select>
                                        </div>
                                    </div>
                                </x-base.form-inline>                                
                            </div>
                        </div>                                              
                    </div>
                </div>                                            

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Digital Services
                        </div>
                        <div class="mt-5">
                            <!-- Digital Services -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Services</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select one or more digital services that this platform offers. You can search and select from the dropdown.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.tom-select 
                                            class="w-full" 
                                            name="digitalServices[]" 
                                            placeholder="Select digital services" 
                                            multiple
                                            data-header="Instructions: Type to search and select relevant digital services"
                                        >

                                            @foreach ($digitalServices as $service)
                                                <option value="{{ $service->id }}" 
                                                    {{ $digital_platform->services && in_array($service->id, $digital_platform->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $service->service_name }}
                                                </option>
                                            @endforeach                                            
                                        </x-base.tom-select>
                                    </div>
                                </div>
                            </x-base.form-inline>
                        </div>                                              
                    </div>
                </div>

                <!-- END: Add Digital Plaform Form -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button type="button" as="a" href="{{ route('digital-platforms.index') }}" class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">
                        Cancel
                    </x-base.button>
                    <x-base.button type="submit" variant="primary" class="w-full py-3 md:w-52">
                        Save
                    </x-base.button>
                </div>                
            </form>
        </div>
    </div>
    <!-- BEGIN: Failed Notification Content -->
    <x-base.notification class="hidden" id="failed-notification-content">
        <x-base.lucide class="text-danger" icon="XCircle" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Create Digital Platform failed</div>
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
    @vite('resources/js/pages/editDigitalPlatform.js')
@endPushOnce