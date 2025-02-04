@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">User List</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.button class="mr-2 shadow-md" variant="primary" href="{{ route('users.create') }}" as="a">
                Add New User
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            <form action="#" class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input
                        name="search"
                        id="search"
                        class="!box w-56 pr-10"
                        type="text"
                        placeholder="Search..."
                        value="{{ request('search') }}"
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
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            ID
                        </x-base.table.th>                        
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            USER DETAILS
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            ASSIGNED ROLES
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>                                                            
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($users as $user)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $user->id }}
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    <div class="image-fit zoom-in h-9 w-9">
                                        <x-base.tippy
                                            class="rounded-lg border-white shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                            src="{{ Vite::asset('resources\images\fakers\preview-2.jpg') }}"
                                            as="img"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <a class="whitespace-nowrap font-medium" href="">
                                            {{ $user->name }}
                                        </a>
                                        <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>                               
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $roleName)
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 mx-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                                {{ $roleName }}
                                            </span>
                                        @endforeach

                                    @endif
                                </div>
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    @can('update users')
                                        <a class="mr-3 flex items-center" href="{{ url('users/'.$user->id.'/edit') }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                            Edit
                                        </a>                                        
                                    @endcan
                                    @can('delete users')
                                        <a class="mr-3 flex items-center text-danger" href="{{ url('users/'.$user->id.'/delete') }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                            Delete
                                        </a>   
                                    @endcan                                 
                                </div>
                            </x-base.table.td>                            
                        </x-base.table.tr>                    
                    @endforeach
                </x-base.table.tbody>                
            </x-base.table>
        </div>
        <!-- END: User List --> 
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

            </x-base.pagination>

            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                <!-- First Page Link -->
                @if ($users->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $users->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Previous Page Link -->
                @if ($users->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $users->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Page Numbers -->
                @foreach ($users->getUrlRange(max(1, $users->currentPage() - 1), min($users->lastPage(), $users->currentPage() + 1)) as $page => $url)
                    @if ($page == $users->currentPage())
                        <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                    @else
                        <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                    @endif
                @endforeach
            
                <!-- Next Page Link -->
                @if ($users->hasMorePages())
                    <x-base.pagination.link href="{{ $users->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Last Page Link -->
                @if ($users->hasMorePages())
                    <x-base.pagination.link href="{{ $users->url($users->lastPage()) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @endif
            </x-base.pagination>
        
            <form method="GET" action="{{ route('users.index') }}" class="mt-3 w-20 sm:mt-0">
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
@endsection