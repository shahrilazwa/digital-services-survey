@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey App</title>
    <meta name="publish-survey-id" content="{{ $publish_survey->id }}">
@endsection

@section('subcontent')
    <div class="mt-8 flex items-center">
        <h2 class="intro-y mr-auto text-lg font-medium">Assign Team Members</h2>
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
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    2
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Schema
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    3
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Platform
                </div>
            </div>            
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full bg-success border-success text-white dark:border-success-600 dark:border-success-400">
                    4
                </x-base.button>
                <div class="ml-3 text-base text-slate-600 dark:text-slate-400 lg:mx-auto lg:mt-3 lg:w-32">
                    Select Service
                </div>
            </div>
            <div class="intro-x z-10 mt-5 flex flex-1 items-center lg:mt-0 lg:block lg:text-center">
                <x-base.button class="h-10 w-10 rounded-full" variant="primary">
                    5
                </x-base.button>
                <div class="ml-3 text-base font-medium lg:mx-auto lg:mt-3 lg:w-32">
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

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.button data-tw-toggle="modal" data-tw-target="#add-team-member-modal" class="mr-2 shadow-md" variant="primary" href="#" as="a">
                Add New Member
            </x-base.button>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing {{ $assignedUsers->firstItem() }} to {{ $assignedUsers->lastItem() }} of {{ $assignedUsers->total() }} members
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

        @foreach ($assignedUsers as $assignedUser)
            <div id="member-row-{{ $assignedUser->id }}" class="intro-y col-span-12 md:col-span-6 user-row" data-member-id="{{ $assignedUser->id }}">
                <div class="box">
                    <div class="flex flex-col items-center p-5 lg:flex-row">
                        <div class="image-fit h-24 w-24 lg:mr-1 lg:h-12 lg:w-12">
                            <img class="rounded-full" src="{{ Vite::asset('resources/images/fakers/preview-3.jpg') }}" />
                        </div>                            
        
                        <div class="mt-3 text-center lg:ml-2 lg:mr-auto lg:mt-0 lg:text-left">
                            <a class="font-medium" href="">
                                {{ $assignedUser->name }}
                            </a>
                            <div class="mt-0.5 text-xs text-slate-500">
                                {{ ucfirst($assignedUser->pivot->role) }}
                            </div>
                        </div>
        
                        <!-- Remove the inline onclick, just add a class for JavaScript to target -->
                        <div class="mt-4 flex lg:mt-0">
                            @if($assignedUser->pivot->role !== 'Author')
                                <x-base.button class="mr-2 px-2 py-1 remove-button" variant="danger" data-user-id="{{ $assignedUser->id }}">
                                    Remove
                                </x-base.button>
                            @endif
                            <x-base.button class="px-2 py-1" variant="outline-secondary">
                                View
                            </x-base.button>
                        </div>
                    </div>                        
                </div>
            </div>
        @endforeach
    </div>

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap mt-20">
        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">

        </x-base.pagination>

        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
            <!-- First Page Link -->
            @if ($assignedUsers->onFirstPage())
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link href="{{ $assignedUsers->url(1) }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronsLeft" />
                </x-base.pagination.link>
            @endif
        
            <!-- Previous Page Link -->
            @if ($assignedUsers->onFirstPage())
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link href="{{ $assignedUsers->previousPageUrl() }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                </x-base.pagination.link>
            @endif
        
            <!-- Page Numbers -->
            @foreach ($assignedUsers->getUrlRange(max(1, $assignedUsers->currentPage() - 1), min($assignedUsers->lastPage(), $assignedUsers->currentPage() + 1)) as $page => $url)
                @if ($page == $assignedUsers->currentPage())
                    <x-base.pagination.link active>{{ $page }}</x-base.pagination.link>
                @else
                    <x-base.pagination.link href="{{ $url }}">{{ $page }}</x-base.pagination.link>
                @endif
            @endforeach
        
            <!-- Next Page Link -->
            @if ($assignedUsers->hasMorePages())
                <x-base.pagination.link href="{{ $assignedUsers->nextPageUrl() }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                </x-base.pagination.link>
            @endif
        
            <!-- Last Page Link -->
            @if ($assignedUsers->hasMorePages())
                <x-base.pagination.link href="{{ $assignedUsers->url($assignedUsers->lastPage()) }}">
                    <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                </x-base.pagination.link>
            @else
                <x-base.pagination.link disabled>
                    <x-base.lucide class="h-4 w-4" icon="ChevronsRight" />
                </x-base.pagination.link>
            @endif
        </x-base.pagination>
    
        <form method="GET" action="{{ route('schemas.createTeam', $publish_survey->id) }}" class="mt-3 w-20 sm:mt-0">
            <x-base.form-select class="!box" name="per_page" onchange="this.form.submit()">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="35" {{ $perPage == 35 ? 'selected' : '' }}>35</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            </x-base.form-select>
        </form>
    </div>
    <!-- END: Pagination -->

    <!-- BEGIN: Buttons -->
    <div class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
        <x-base.button
            class="w-24"
            variant="secondary"
            as="a" 
            href="{{ route('publish-surveys.selectService', $publish_survey->id) }}"
        >
            Previous
        </x-base.button>
        <x-base.button
            id="nextButton"
            class="ml-2 w-24"
            variant="primary"
            as="a"
            href="{{ route('publish-surveys.publish', $publish_survey->id) }}" 
        >
            Next
        </x-base.button>
    </div>
    <!-- END: Buttons -->
    
    <!-- BEGIN: Large Modal Content -->
    <x-base.dialog id="add-team-member-modal" size="lg" staticBackdrop>
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">
                    Search New Team Member
                </h2>
            </x-base.dialog.title>

            <x-base.dialog.description>
                <div class="id grid-cols-11 pb-5">
                    <div class="col-span-11 2xl:col-span-9">
                        <form id="add-member-form">
                            @csrf
                            <x-base.form-inline formInline class="flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row">
                                <x-base.form-label class="xl:!mr-5 xl:w-40">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">User</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select a new team member.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-1 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.tom-select 
                                            class="form-control" 
                                            name="add-user" 
                                            placeholder="Select a user"
                                            data-header="Instructions: Type to search and select a user"
                                        >
                                            <option value="">Select a user</option>
                                            @foreach ($allUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-base.tom-select>
                                    </div>
                                </div>
                            </x-base.form-inline>

                            <!-- Member Role -->
                            <x-base.form-inline class="flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-5 xl:w-40">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Role</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select member's role in the team.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-1 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-select class="w-full" name="roles[]" placeholder="Select Role" required>
                                            <option value="" disabled selected hidden>Select member's role</option>
                                            <option value="Co-Author">Co-Author</option>
                                            <option value="Reviewer">Reviewer</option>
                                        </x-base.form-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>

                            <!-- Member Start Date -->
                            {{-- <x-base.form-inline class="flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-5 xl:w-40">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Start Date</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select the start date for the team member.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-1 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <div class="relative mx-auto w-56">
                                            <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                                <x-base.lucide class="h-4 w-4" icon="Calendar"/>
                                            </div>
                                            <x-base.litepicker class="pl-12" data-single-mode="true" />
                                        </div>
                                    </div>
                                </div>
                            </x-base.form-inline> --}}

                            <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                                <x-base.button
                                    class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-32"
                                    type="button"
                                    data-tw-dismiss="modal"                   
                                >
                                    Cancel
                                </x-base.button>
                                <x-base.button
                                    class="w-full py-3 md:w-32"
                                    type="submit"
                                    variant="primary"
                                >
                                    Add Member
                                </x-base.button>
                            </div>
                        </form>
                    </div>
                </div>
            </x-base.dialog.description>

            <x-base.dialog.footer>

            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Large Modal Content -->        
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')    
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/selectTeam.js')
@endPushOnce