@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Publish Survey</title>
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Select Survey Schema</h2>
    </div>
    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box mt-5 py-10 sm:py-5">
        <div class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[69%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block">
            <div class="intro-x z-10 flex flex-1 items-center lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    1
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Details
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full" variant="primary">
                    2
                </x-base.button>
                <div class="ml-3 text-base font-medium lg:mx-auto lg:mt-3 lg:w-32">
                    Select Schema
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    3
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select App
                </div>
            </div>            
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    4
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Service
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    5
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Create Team
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400">
                    6
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Publish Survey
                </div>
            </div>                       
        </div>
    </div>
    <!-- END: Wizard Layout -->
   
    <!-- BEGIN: Notification -->
    <div class="intro-y col-span-12 mt-6 ">
        <x-base.alert
            class="box mb-6 flex items-center dark:border-darkmode-600"
            variant="primary"
            dismissible
        >
            <span>
                Enter the schema title or a keyword in the search bar below and press 'Enter' to 
                find matching schemas. Select your desired schema by clicking its checkbox, then 
                press 'Next' to proceed.
            </span>
            <x-base.alert.dismiss-button class="text-white">
                <x-base.lucide
                    class="h-4 w-4"
                    icon="X"
                />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    </div>
    <!-- BEGIN: Notification -->
    
    <div class="intro-y block mt-6 h-10 items-center sm:flex">
        <h2 class="mr-5 truncate text-lg font-medium">
            Survey Schema List
        </h2>
        <div class="mt-3 flex items-center sm:ml-auto sm:mt-0">
            <form action="#" class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
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
                </div>
            </form> 
        </div>
    </div>
    
    <!-- BEGIN: Survey Schema List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <form>
            @csrf
            <input type="hidden" name="survey-id" value="{{ $publish_survey->id }}">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            
                        </x-base.table.th>                       
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            TITLE
                        </x-base.table.th>                      
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>                                                            
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($schemas as $schema)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="box w-10 whitespace-nowrap rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600"
                                data-schema-id="{{ $schema->id }}"
                                data-schema-title="{{ $schema->title }}"
                            >
                                <x-base.form-check.input 
                                    type="checkbox"
                                    :checked="$schema->id == $publish_survey->schema_id"
                                />
                            </x-base.table.td>
                            <x-base.table.td class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    <a class="whitespace-nowrap font-medium" href="">
                                        {{ $schema->title ?? 'N/A' }}
                                    </a>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td @class([
                                'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                                'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                            ])>
                                <div class="flex items-center justify-center">
                                    @can('delete users')
                                        <a class="mr-3 flex items-center text-primary"
                                            data-tw-toggle="modal" 
                                            data-tw-target="#modal-survey-preview"
                                            data-survey-id="{{ $schema->id }}"
                                            href="#"
                                        >
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="eye" />
                                            View
                                        </a>   
                                    @endcan                                
                                </div>                        
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                
                </x-base.table.tbody>
            </x-base.table>
            
            <div class="mt-6 mb-6 flex flex-col justify-end gap-2 md:flex-row">
                <x-base.button type="button" as="a" href="{{ route('publish-surveys.edit', $publish_survey->id) }}" class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">
                    Previous
                </x-base.button>
                <x-base.button type="submit" id="next-button" variant="primary" class="w-full py-3 md:w-52">
                    Next
                    <input type="hidden" id="selected-schema-id" name="selected-schema-id" value="{{ $publish_survey->schema_id }}">
                    <input type="hidden" id="selected-schema-title" name="title">
                </x-base.button>
            </div>
        </form>       
    </div>
    <!-- BEGIN: Survey Schema List -->
    
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
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
        

        <form method="GET" action="{{ route('publish-surveys.selectSchema', $publish_survey->id) }}" class="mt-3 w-20 sm:mt-0">
            <x-base.form-select class="!box" name="per_page" onchange="this.form.submit()">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="35" {{ $perPage == 35 ? 'selected' : '' }}>35</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            </x-base.form-select>
        </form>
    </div>
    <!-- END: Pagination -->
    
    <!-- BEGIN: Modal Survey Preview -->
    <x-base.dialog id="modal-survey-preview" size="lg">
        <x-base.dialog.panel class="p-10 text-center">
            <div id="modal-survey-content" class="text-center">
                <div id="survey-viewer-modal-app"></div>
                <div id="survey-results" class="mt-4 text-left text-sm"></div>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Survey Preview -->
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/selectSchema.js')
@endPushOnce