@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Add New User</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">

        <!-- BEGIN: User Registration Form -->
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form method="POST" class="validate-form">
                @csrf
                <!-- BEGIN: User Profile -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Profile Information
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">User Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Name as it appears on passport or national identity card, using 5 to 80 characters.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input id="user-name" name="user-name" type="text" placeholder="User name" autocomplete="username" required minlength="5" />
                                    </div>
                                </div>
                            </x-base.form-inline>                          
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Official Email</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Official mail will be the login name and is required for password recovery and identity verification.
                                        </div>                                    
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input id="user-email" name="user-email" type="email" placeholder="User email" autocomplete="email" required />
                                    </div>
                                </div>                            
                            </x-base.form-inline>
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Personal Email</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Personal mail is required as an alternatif email for identity verification.
                                        </div>                                    
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input id="personal-email" name="personal-email" type="email" placeholder="Personal email" autocomplete="email" required />
                                    </div>
                                </div>                            
                            </x-base.form-inline>
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <x-base.alert class="bg-info/20 dark:border-darkmode-400 dark:bg-darkmode-400" variant="outline-info" dismissible>
                                        <div class="flex items-center">
                                            <span>
                                                <x-base.lucide class="mr-3 h-6 w-6" icon="info" />
                                            </span>
                                            <span class="text-xs text-slate-800 dark:text-slate-500">
                                                <span class="font-medium text-slate-600 dark:text-slate-300">Government</span> users from government bodies or agencies.<br>
                                                <span class="font-medium text-slate-600 dark:text-slate-300">Non-Government</span> external users not affiliated with the government.<br>
                                                <span class="font-medium text-slate-600 dark:text-slate-300">Admin</span> users with access to manage system settings and configurations.                                                
                                            </span>
                                            <x-base.alert.dismiss-button class="dark:text-white">
                                                <x-base.lucide class="h-4 w-4" icon="X" />
                                            </x-base.alert.dismiss-button>
                                        </div>
                                    </x-base.alert>
                                </div>
                            </x-base.form-inline>
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">User Type</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Please choose the appropriate user type from the list for this user.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-select class="w-full" name="userTypes[]" placeholder="Select user type" required>
                                            <option value="" disabled selected hidden>Select user type</option>
                                            @foreach($userTypes as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </x-base.form-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <div class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">User Placement</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Specify the user's placement, indicating whether they are placed at an organization or an agency. 
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="flex flex-col sm:flex-row">
                                        <x-base.form-check class="mr-4">
                                            <x-base.form-check.input
                                                id="atOrganization"
                                                name="placement"
                                                type="radio"
                                                value="organization"
                                                required
                                            />
                                            <x-base.form-check.label>
                                                <div>Organization</div>
                                                <div class="mt-1 w-56 text-xs leading-relaxed text-slate-500">
                                                    User is assigned directly at state government or ministry.
                                                </div>
                                            </x-base.form-check.label>
                                        </x-base.form-check>
                                        <x-base.form-check class="mr-4 mt-2 sm:mt-0">
                                            <x-base.form-check.input
                                                id="atAgency"
                                                name="placement"
                                                type="radio"
                                                value="agency"
                                                required
                                            />
                                            <x-base.form-check.label>
                                                <div>Agency</div>
                                                <div class="mt-1 w-56 text-xs leading-relaxed text-slate-500">
                                                    User is assigned at federal, state agency or statutory body.
                                                </div>
                                            </x-base.form-check.label>
                                        </x-base.form-check>
                                    </div>
                                </div>
                            </x-base.form-inline>
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
                                                Select ministry or state government from the list.
                                            </div>
                                        </div>
                                    </x-base.form-label>
                                    <div class="mt-3 w-full flex-1 xl:mt-0">
                                        <div class="input-form">
                                            <x-base.tom-select class="form-control" name="organization" placeholder="Select an organization">
                                                <option value="">Select an organization</option>
                                                @foreach ($organizations as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </x-base.tom-select>
                                        </div>
                                    </div>
                                </x-base.form-inline>
                            </div>
                            <div id="agcyDropdown" class="hidden mt-10">
                                <x-base.form-inline formInline class="hidden mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
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
                                                Select an agency from the list.
                                            </div>
                                        </div>
                                    </x-base.form-label>
                                    <div class="mt-3 w-full flex-1 xl:mt-0">
                                        <div class="input-form">
                                            <x-base.tom-select class="form-control" name="agency" placeholder="Select an agency">
                                                <option value="">Select an agency</option>
                                                @foreach ($agencies as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </x-base.tom-select>
                                        </div>
                                    </div>
                                </x-base.form-inline>
                            </div>                                                                                        
                        </div>
                    </div>
                </div>
                <!-- END: User Profile -->

                <!-- BEGIN: User Password -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Password
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">New Password</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.
                                        </div>                                    
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input 
                                            id="user-password"
                                            name="user-password" 
                                            type="password" 
                                            placeholder="New password"
                                            autocomplete="new-password"
                                            required 
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline> 
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Confirm Password</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Re-enter the new password to confirm. It must match the password entered above.
                                        </div>                                    
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input 
                                            id="confirm-password"
                                            name="confirm-password" 
                                            type="password" 
                                            placeholder="Confirm password"
                                            autocomplete="new-password"
                                            required 
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>
                        </div>                                          
                    </div>
                </div>
                <!-- END: User Password -->

                <!-- BEGIN: User Role -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Access Role
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Roles</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select one or more roles for the user. You can search and select from the dropdown.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.tom-select 
                                            class="w-full" 
                                            name="roles[]" 
                                            placeholder="Select role" 
                                            multiple
                                            data-header="Instructions: Type to search and select relevant roles"
                                        >
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </x-base.tom-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>
                        </div>                                              
                    </div>
                </div>
                <!-- END: User Role -->

                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button type="button" as="a" href="{{ route('users.index') }}" class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">
                        Cancel
                    </x-base.button>
                    <x-base.button type="submit" variant="primary" class="w-full py-3 md:w-52">
                        Save
                    </x-base.button>
                </div>

            </form>          
        </div>
        <!-- END: User Registration Form -->
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/createUser.js')
@endPushOnce