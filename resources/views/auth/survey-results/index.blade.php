@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey Results</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Publish Survey List</h2>
    <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
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
                        <x-base.table.td class="box w-20 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
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
                        <x-base.table.td class="box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <div @class([
                                'flex items-center whitespace-nowrap',
                                'text-success' => $survey->status === 'Active',
                                'text-danger' => $survey->status === 'Closed',
                            ])>
                                {{ $survey->status ?? 'N/A' }}
                            </div>
                        </x-base.table.td>
                        <x-base.table.td @class([
                            'box w-10 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                @can('update users')
                                    <a class="mr-3 flex items-center text-primary" 
                                        href="{{ route('survey-results.view', $survey->id) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="table" />
                                        Table View
                                    </a>
                                @endcan                             
                            </div>
                        </x-base.table.td>                                                        
                    </x-base.table.tr>
                @endforeach                 
            </x-base.table.tbody>
        </x-base.table>
    </div>
@endsection