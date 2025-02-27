@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Role List</title>
@endsection

@section('subcontent')
    @dump(session()->all())
    <h2 class="intro-y mt-10 text-lg font-medium">Role List</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.button class="mr-2 shadow-md" variant="primary" href="{{ route('roles.create') }}" as="a">
                Add New Role
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} roles                
            </div>
            <form method="GET" action="{{ route('roles.index') }}" class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input
                        name="search"
                        class="!box w-56 pr-10"
                        type="text"
                        placeholder="Search..."
                        value="{{ request('search') }}" {{-- Pre-fill with existing search term --}}
                    />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search"/>
                </div>
            </form> 
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-left">
                            
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-left">
                            ROLE NAME
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($roles as $role)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box w-5 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}
                            </x-base.table.td>
                            <x-base.table.td class="box w-56 rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $role->name }}
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    @can('update roles')
                                        <a class="mr-3 flex items-center" href="{{ route('roles.edit', $role->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="pencil-ruler" />
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete roles')    
                                        {{-- <a class="flex items-center text-danger" href="{{ url('roles/'.$role->id.'/delete') }}"> --}}
                                        <a class="flex items-center text-danger"
                                            href="#" 
                                            data-tw-merge
                                            data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}"
                                            id="delete-button"
                                        >                                            
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> 
                                            Delete
                                        </a>
                                    @endcan
                                    <a class="ml-3 flex items-center text-warning" href="{{ url('roles/'.$role->id.'/give-permissions') }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="key-square" /> 
                                        Permissions
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

            </x-base.pagination>

            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                <!-- First Page Link -->
                @if ($roles->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $roles->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Previous Page Link -->
                @if ($roles->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $roles->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Page Numbers -->
                @foreach ($roles->getUrlRange(max(1, $roles->currentPage() - 1), min($roles->lastPage(), $roles->currentPage() + 1)) as $page => $url)
                    @if ($page == $roles->currentPage())
                        <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                    @else
                        <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                    @endif
                @endforeach
            
                <!-- Next Page Link -->
                @if ($roles->hasMorePages())
                    <x-base.pagination.link href="{{ $roles->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Last Page Link -->
                @if ($roles->hasMorePages())
                    <x-base.pagination.link href="{{ $roles->url($roles->lastPage()) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @endif
            </x-base.pagination>
            

            <form method="GET" action="{{ route('roles.index') }}" class="mt-3 w-20 sm:mt-0">
                <x-base.form-select class="!box" name="per_page" onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="35" {{ $perPage == 35 ? 'selected' : '' }}>35</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </x-base.form-select>
            </form>
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Delete Confirmation Content -->
    <x-base.notification
        class="flex"
        id="delete-confirmation"
    >
        <x-base.lucide icon="HardDrive" />
        <div class="ml-4 mr-4">
            <div class="font-medium">Delete Role</div>
            <div class="mt-1 text-slate-500">
                Are you sure you want to delete {{ $role->name }} role?
            </div>
            <div class="mt-1.5 flex font-medium">
                <a
                    class="text-primary dark:text-slate-400"
                    href="{{ url('roles/'.$role->id.'/delete') }}"
                >
                    Confirm
                </a>
                <a
                    class="ml-3 text-slate-500"
                    href=""
                >
                    Cancel
                </a>
            </div>
        </div>
    </x-base.notification>
    <!-- END: Delete Confirmation Content -->

    @foreach (['success', 'error'] as $type)
        @if (session($type))
            <div id="{{ $type }}-message" data-message="{{ session($type) }}"></div>
        @endif
    @endforeach

    <!-- BEGIN: Success Notification Content -->
    <x-base.notification
        class="flex"
        id="success-notification-content"
        data-message="{{ session('success') }}"
    >
        <x-base.lucide
            class="text-success"
            icon="CheckCircle"
        />
        <div class="ml-4 mr-4">
            <div class="font-medium">Success!</div>
            <div class="mt-1 text-slate-500">
                {{ session('success') }}
            </div>
        </div>
    </x-base.notification>
    <!-- END: Success Notification Content -->

    <!-- BEGIN: Error Notification Content -->
    <x-base.notification
        class="flex"
        id="error-notification-content"
        data-message="{{ session('error') }}"
    >
        <x-base.lucide
            class="text-danger"
            icon="XCircle"
        />
        <div class="ml-4 mr-4">
            <div class="font-medium">Failed!</div>
            <div class="mt-1 text-slate-500">
                {{ session('error') }}
            </div>
        </div>
    </x-base.notification>
    <!-- END: Error Notification Content -->    
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/listRoles.js')
@endPushOnce