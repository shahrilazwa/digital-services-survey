@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Add Role</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Add Role</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form method="POST" class="validate-form">
                @csrf
                <!-- BEGIN: Add Role Form -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Role Details
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="role-name">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Role Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="role-name"
                                            name="role-name"
                                            type="text"
                                            placeholder="Role name"
                                            minlength="5"
                                            required
                                        />
                                        <x-base.form-help class="text-right"> Maximum character 0/70 </x-base.form-help>
                                    </div>
                                </div>
                            </x-base.form-inline>
                            <x-base.form-inline
                                class="mt-2 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row"
                                formInline
                            >
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="role-desc">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Description</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide a detailed explanation of the role.
                                        </div>                                        
                                    </div>
                                </x-base.form-label>
                                
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="role-desc" 
                                        name="role-desc" 
                                        placeholder="Brief description of role"
                                    ></x-base.form-textarea>
                                </div>
                            </x-base.form-inline>                            
                        </div>
                    </div>
                </div>
                <!-- END: Add Role Form -->

                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button
                        class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52"
                        type="button"
                        href="{{ route('roles.index') }}"
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
    @vite('resources/js/pages/createRole.js')
@endPushOnce