@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey Schema</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Survey Schema List</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            @can('create survey schema')
                <x-base.button class="mr-2 shadow-md" variant="primary" href="{{ route('schemas.create') }}" as="a">
                    Add New Schema
                </x-base.button>
            @endcan
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing {{ $schemas->firstItem() }} to {{ $schemas->lastItem() }} of {{ $schemas->total() }} schemas                
            </div>
            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <form action="#" class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                    <div class="mt-3 flex w-full items-center xl:mt-0 xl:w-auto">
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
                        <x-base.form-select name="status" class="!box w-full ml-1 sm:w-56 xl:w-auto">
                            <option>Status</option>
                            <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Available" {{ request('status') === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="In-Use" {{ request('status') === 'In-Use' ? 'selected' : '' }}>In-Use</option>
                            <option value="Archived" {{ request('status') === 'Archived' ? 'selected' : '' }}>Archived</option>
                        </x-base.form-select>
                    </div>
                </form>
            </div>            
        </div>
        <!-- BEGIN: Schema List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            ID
                        </x-base.table.th>                        
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            TITLE
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            STATUS
                        </x-base.table.th>                                             
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>                                                            
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($schemas as $schema)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                {{ $loop->iteration + ($schemas->currentPage() - 1) * $schemas->perPage() }}
                            </x-base.table.td>
                            <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    <a class="whitespace-nowrap font-medium" href="">
                                        {{ $schema->title ?? 'N/A' }}
                                    </a>
                                </div>                               
                            </x-base.table.td>
                            <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <span @class([
                                    'mr-1 rounded-full px-2 py-1 text-white text-xs',
                                    'bg-warning' => $schema->status === 'Draft',
                                    'bg-success' => $schema->status === 'Available',
                                    'bg-danger'  => $schema->status === 'In-Use',
                                    'bg-gray-500' => $schema->status === 'Closed',
                                ])>
                                    {{ $schema->status ?? 'N/A' }}
                                </span>
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    @can('view survey schema')
                                        <a class="mr-3 flex items-center text-primary view-schema"
                                            data-tw-toggle="modal" 
                                            data-tw-target="#slide-over-details"
                                            data-schema-id="{{ $schema->id }}"
                                            href="#"
                                        >
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="book-open-text" />
                                            Details
                                        </a>                                        
                                    @endcan                                    
                                    @can('update survey schema')
                                        <a class="mr-3 flex items-center text-slate-500" href="{{ route('schemas.edit', $schema->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="checkSquare" />
                                            Edit
                                        </a>                                        
                                    @endcan
                                    @can('view survey schema')
                                        <a class="mr-3 flex items-center text-primary"
                                            data-tw-toggle="modal" 
                                            data-tw-target="#modal-schema-preview"
                                            data-schema-id="{{ $schema->id }}"
                                            href="#"
                                        >
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="eye" />
                                            Preview
                                        </a>   
                                    @endcan                                    
                                    @can('delete survey schema')
                                        <a class="mr-3 flex items-center text-danger" href="{{ route('schemas.delete', $schema->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="trash" />
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
        <!-- END: Schema List --> 
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

            </x-base.pagination>

            <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                <!-- First Page Link -->
                @if ($schemas->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $schemas->url(1) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Previous Page Link -->
                @if ($schemas->onFirstPage())
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $schemas->previousPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Page Numbers -->
                @foreach ($schemas->getUrlRange(max(1, $schemas->currentPage() - 1), min($schemas->lastPage(), $schemas->currentPage() + 1)) as $page => $url)
                    @if ($page == $schemas->currentPage())
                        <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                    @else
                        <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                    @endif
                @endforeach
            
                <!-- Next Page Link -->
                @if ($schemas->hasMorePages())
                    <x-base.pagination.link href="{{ $schemas->nextPageUrl() }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                    </x-base.pagination.link>
                @endif
            
                <!-- Last Page Link -->
                @if ($schemas->hasMorePages())
                    <x-base.pagination.link href="{{ $schemas->url($schemas->lastPage()) }}">
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @else
                    <x-base.pagination.link disabled>
                        <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                    </x-base.pagination.link>
                @endif
            </x-base.pagination>
            

            <form method="GET" action="{{ route('schemas.index') }}" class="mt-3 w-20 sm:mt-0">
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

    <!-- BEGIN: Modal Schema Preview -->
    <x-base.dialog id="modal-schema-preview" size="xl">
        <x-base.dialog.panel class="p-10 text-center">
            <div id="modal-schema-content" class="text-center">
                <div id="schema-viewer-modal-app"></div>
                <div id="schema-results" class="mt-4 text-left text-sm"></div>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Schema Preview -->
    
    <!-- BEGIN: Slide Over Content -->
    <x-base.slideover id="slide-over-details">
        <x-base.slideover.panel>
            <x-base.slideover.title class="p-5">
                <h2 id="schema-title" class="mr-auto text-base font-medium">
                    Schema Details
                </h2>
            </x-base.slideover.title>
            <x-base.slideover.description id="schema-description">
                Loading...
            </x-base.slideover.description>
        </x-base.slideover.panel>
    </x-base.slideover>
    <!-- END: Slide Over Content -->     
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/previewSurvey.js')
    @vite('resources/js/pages/schemaDetails.js')
@endPushOnce