@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Update Agency</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Update Agency</h2>
    </div>
    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form class="validate-form">
                @csrf
                <!-- BEGIN: Add Agency Form -->
                <input type="hidden" name="agency-id" value="{{ $agency->id }}">

                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> 
                            Agency Information
                        </div>
                        <div class="mt-5">
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Agency Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the name of the agency, ensuring proper capitalization and spelling.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input
                                            id="agency-name"  
                                            name="agency-name" 
                                            type="text" 
                                            placeholder="Agency name"
                                            value="{{ $agency->agency_name }}" 
                                            required
                                            minlength="5"
                                        />
                                    </div>
                                </div>
                            </x-base.form-inline>
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Agency Abbreviation</div> 
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter the abbreviation for the agency, without any spaces or special characters.
                                        </div>                                                                      
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <div class="relative w-56">
                                            <x-base.form-input
                                                id="agency-abb"  
                                                name="agency-abb" 
                                                type="text" 
                                                placeholder="Agency abbreviation"
                                                value="{{ $agency->abbreviation }}" 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </x-base.form-inline>  


                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <div class="font-medium">Organization</div>
                                            </div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>                                            
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Select organization for the agency from the list.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.tom-select required class="form-control" name="organization" id="organization" placeholder="Select an organization">
                                            <option value="">Select an organization</option>
                                            @foreach ($organizations as $id => $name)
                                                <option value="{{ $id }}" {{ $agency->org_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </x-base.tom-select>
                                    </div>
                                </div>                                                        
                            </x-base.form-inline>

                            <!-- Description -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 first:mt-0 first:pt-0 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Description</div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Provide a detailed description of the agency.
                                        </div>
                                    </div>
                                </x-base.form-label>
                                <div class="mt-2 w-full flex-1 xl:mt-0">
                                    <x-base.form-textarea
                                        id="agcy-desc"
                                        name="agcy-desc"
                                        rows="5"
                                        placeholder="Enter organization description"
                                    >{{ old('agcy-desc', $agency->description) }}
                                    </x-base.form-textarea>
                                </div>
                            </x-base.form-inline>                            
                        </div>
                    </div>
                </div>
                <!-- END: Add Ministry Form -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button
                        class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52"
                        type="button"
                        href="{{ route('agencies.index') }}"
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
    @vite('resources/js/pages/editAgency.js')
@endPushOnce