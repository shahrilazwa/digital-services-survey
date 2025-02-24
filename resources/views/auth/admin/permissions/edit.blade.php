@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit Permission</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Edit Permission</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form class="validate-form">
                @csrf
                <!-- BEGIN: Edit Permission Form -->
                <input type="hidden" name="perm-id" value="{{ $permission->id }}">

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown"
                            /> Permission Details
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline
                                class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row"
                                formInline
                            >
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="perm-name">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Permission Name</div>
                                            <div
                                                class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter a unique name for the permission (e.g., "view users", "delete surveys").
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="perm-name"
                                            name="perm-name"
                                            type="text"
                                            value="{{ $permission->name }}"
                                            minlength="5"
                                            required
                                        />
                                        <x-base.form-help class="text-right"> Maximum character 0/70 </x-base.form-help>
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <x-base.form-inline
                                class="mt-3 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row"
                                formInline
                            >
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="perm-group">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Group</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter a category for grouping related permissions (e.g., "Users", "Surveys").
                                        </div>                                        
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="perm-group"
                                            name="perm-group"
                                            type="text"
                                            value="{{ $permission->group }}"
                                            placeholder="Group name (e.g., Users, Surveys)"
                                            minlength="5"
                                            required
                                        />
                                        <x-base.form-help class="text-right"> Maximum character 0/70 </x-base.form-help>
                                    </div>
                                </div>
                            </x-base.form-inline>
                            
                            <x-base.form-inline
                                class="mt-3 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row"
                                formInline
                            >
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="perm-desc">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Description</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide a detailed explanation of the permission.
                                        </div>                                        
                                    </div>
                                </x-base.form-label>
                                
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="perm-desc" 
                                        name="perm-desc" 
                                        placeholder="Brief description of permission"
                                    >{{ $permission->description }}</x-base.form-textarea>
                                </div>
                            </x-base.form-inline>                            
                        </div>
                    </div>
                </div>
                <!-- END: Edit Permission Form -->

                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button
                        class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52"
                        type="button"
                        href="{{ route('permissions.index') }}"
                        as="a"                    
                    >
                        Cancel
                    </x-base.button>
                    <x-base.button
                        class="w-full py-3 md:w-52"
                        type="submit"
                        variant="primary"
                    >
                        Update
                    </x-base.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/axios.js')
@endPushOnce

@pushOnce('scripts')
    <script>
        window.routes = {
            permissionsIndex: @json(route('permissions.index'))
        };
    </script>
    
    @vite('resources/js/pages/editPermission.js')
@endPushOnce