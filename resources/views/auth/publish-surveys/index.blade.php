@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Publish Survey</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Publish Survey List</h2>
    <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
        <x-base.button class="mr-2 shadow-md" variant="primary" href="{{ route('publish-surveys.create') }}" as="a">
            Publish New Survey
        </x-base.button>
        <div class="mx-auto hidden text-slate-500 md:block">
            Showing {{ $publishSurveys->firstItem() }} to {{ $publishSurveys->lastItem() }} of {{ $publishSurveys->total() }} published surveys                
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
                    <x-base.form-select name="status" class="!box w-full sm:w-56 xl:w-auto">
                        <option>Status</option>
                        <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </x-base.form-select>
                </div>
            </form>
        </div>
    </div>
    
    <!-- BEGIN: Published Survey List -->
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
                @foreach ($publishSurveys as $survey)
                    <x-base.table.tr class="intro-x">
                        <x-base.table.td class="box w-5 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $survey->id }}
                        </x-base.table.td>
                        <x-base.table.td class="box w-30 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <div class="flex items-center">
                                <div class="">
                                    <a class=" font-medium" href="">
                                        {{ $survey->title ?? 'N/A' }}
                                    </a>
                                    <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                        URL : {{ $survey->survey_link ?? 'Not Available' }}
                                    </div>
                                </div>
                            </div>
                        </x-base.table.td>
                        <x-base.table.td class="box w-5 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <span @class([
                                'mr-1 rounded-full px-2 py-1 text-white text-xs whitespace-nowrap',
                                'bg-warning' => $survey->status === 'Draft',
                                'bg-success' => $survey->status === 'Published',
                                'bg-danger'  => $survey->status === 'Closed',
                                'bg-gray-500' => $survey->status === 'Archived',
                            ])>
                                {{ $survey->status ?? 'N/A' }}
                            </span>                            
                        </x-base.table.td>
                        <x-base.table.td @class([
                            'box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                @can('delete users')
                                    <a class="mr-3 flex items-center text-success view-survey"
                                        data-tw-toggle="modal" 
                                        data-tw-target="#slide-over-details"
                                        data-survey-id="{{ $survey->id }}"
                                        href="#"
                                    >
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="book-open-text" />
                                        Details
                                    </a>   
                                @endcan                                
                                @can('update users')
                                    <a class="mr-3 flex items-center text-warning" 
                                        href="{{ route('publish-surveys.edit', $survey->id) }}"
                                    >
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                        Edit
                                    </a>                                        
                                @endcan
                                @can('delete users')
                                    <button class="mr-3 flex items-center text-danger delete-survey" 
                                            data-id="{{ $survey->id }}" 
                                            data-title="{{ $survey->title }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                        Delete
                                    </button>
                                @endcan                                
                            </div>
                        </x-base.table.td>                                                        
                    </x-base.table.tr>
                @endforeach                    
            </x-base.table.tbody>
        </x-base.table>
    </div>
    <!-- END: Published Survey List -->
        
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

        </x-base.pagination>

        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
            <!-- First Page Link -->
            @if ($publishSurveys->onFirstPage())
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link href="{{ $publishSurveys->url(1) }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                </x-base.pagination.link>
            @endif
        
            <!-- Previous Page Link -->
            @if ($publishSurveys->onFirstPage())
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link href="{{ $publishSurveys->previousPageUrl() }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                </x-base.pagination.link>
            @endif
        
            <!-- Page Numbers -->
            @foreach ($publishSurveys->getUrlRange(max(1, $publishSurveys->currentPage() - 1), min($publishSurveys->lastPage(), $publishSurveys->currentPage() + 1)) as $page => $url)
                @if ($page == $publishSurveys->currentPage())
                    <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                @endif
            @endforeach
        
            <!-- Next Page Link -->
            @if ($publishSurveys->hasMorePages())
                <x-base.pagination.link href="{{ $publishSurveys->nextPageUrl() }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                </x-base.pagination.link>
            @endif
        
            <!-- Last Page Link -->
            @if ($publishSurveys->hasMorePages())
                <x-base.pagination.link href="{{ $publishSurveys->url($publishSurveys->lastPage()) }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                </x-base.pagination.link>
            @endif
        </x-base.pagination>
        

        <form method="GET" action="{{ route('publish-surveys.index') }}" class="mt-3 w-20 sm:mt-0">
            <x-base.form-select class="!box" name="per_page" onchange="this.form.submit()">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="35" {{ $perPage == 35 ? 'selected' : '' }}>35</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            </x-base.form-select>
        </form>
    </div>
    <!-- END: Pagination -->

    <!-- BEGIN: Slide Over Content -->
    <x-base.slideover id="slide-over-details">
        <x-base.slideover.panel>
            <x-base.slideover.title class="p-5">
                <h2 id="survey-title" class="mr-auto text-base font-medium">
                    Survey Details
                </h2>
            </x-base.slideover.title>
            <x-base.slideover.description id="survey-description">
                Loading...
            </x-base.slideover.description>
        </x-base.slideover.panel>
    </x-base.slideover>
    <!-- END: Slide Over Content -->    
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/deletePublishSurvey.js')
    @vite('resources/js/pages/publishSurveyDetails.js')
@endPushOnce