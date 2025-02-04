@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Digital Platform List</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.button class="mr-2 shadow-md" variant="primary" href="{{ route('digital-platforms.create') }}" as="a">
                Add New Digital Platform
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing {{ $digitalPlatforms->firstItem() }} to {{ $digitalPlatforms->lastItem() }} of {{ $digitalPlatforms->total() }} digital platforms
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
        <!-- BEGIN: Digital Platforms List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            ID
                        </x-base.table.th>                        
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            DETAILS
                        </x-base.table.th>                       
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>                                                            
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($digitalPlatforms as $platform)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $platform->id }}
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <a class="whitespace-nowrap font-medium" href="">
                                            {{ $platform->platform_name }}
                                        </a>
                                        <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                            {{ $platform->url ?? 'No URL Assigned' }}
                                        </div>
                                    </div>
                                </div>
                            </x-base.table.td>                            
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    @can('update users')
                                        <a class="mr-3 flex items-center" href="{{ url('digital-platforms/'.$platform->id.'/edit') }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                            Edit
                                        </a>                                        
                                    @endcan
                                    @can('delete users')
                                        <a class="mr-3 flex items-center text-danger" 
                                            href="{{ url('digital-platforms/'.$platform->id.'/delete') }}"
                                            onclick="return confirm('Are you sure you want to delete this digital platform?')"
                                        >
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
        <!-- END: Digital Platforms List -->

        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

            </x-base.pagination>

            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                <!-- First Page Link -->
                @if ($digitalPlatforms->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $digitalPlatforms->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Previous Page Link -->
                @if ($digitalPlatforms->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $digitalPlatforms->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Page Numbers -->
                @foreach ($digitalPlatforms->getUrlRange(max(1, $digitalPlatforms->currentPage() - 1), min($digitalPlatforms->lastPage(), $digitalPlatforms->currentPage() + 1)) as $page => $url)
                    @if ($page == $digitalPlatforms->currentPage())
                        <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                    @else
                        <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                    @endif
                @endforeach
            
                <!-- Next Page Link -->
                @if ($digitalPlatforms->hasMorePages())
                    <x-base.pagination.link href="{{ $digitalPlatforms->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Last Page Link -->
                @if ($digitalPlatforms->hasMorePages())
                    <x-base.pagination.link href="{{ $users->url($digitalPlatforms->lastPage()) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @endif
            </x-base.pagination>
        
            <form method="GET" action="{{ route('digital-platforms.index') }}" class="mt-3 w-20 sm:mt-0">
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
    <!-- BEGIN: Notification Content -->
    <x-base.notification class="hidden" id="notification-content">
        <x-base.lucide class="text-success" icon="CheckCircle" />
        <div class="ml-4 mr-4">
            <div id="toast-title" class="font-medium"></div>
            <div id="toast-details" class="mt-1 text-slate-500"></div>
        </div>
    </x-base.notification>
    <!-- END: Notification Content -->

@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/toastify.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/listDigitalPlatform.js')
@endPushOnce