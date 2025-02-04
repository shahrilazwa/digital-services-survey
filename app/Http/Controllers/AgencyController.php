<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Agencies', 'url' => route('agencies.index'), 'active' => true],
        ];
        
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $agencies = Agency::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $agencies->where('agency_name', 'like', '%' . $search . '%');
        }

        $agencies = $agencies->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);          

        return view('auth.admin.agencies.index', compact('agencies', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Agencies', 'url' => route('agencies.index'), 'active' => true],
            ['label' => 'Create Agency', 'url' => route('agencies.create'), 'active' => true],
        ];          
        $organizations = Organization::pluck('org_name','id')->all();
        return view('auth.admin.agencies.create', compact('organizations', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','min:5','max:80'],
            'organization' => ['required', 'exists:organizations,id'],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Agency name is required.',
            'name.string' => 'Agency name must be a valid string.',
            'name.min' => 'Agency name must be at least 5 characters.',
            'organization.required' => 'Please select a organization.'
        ]); 

        Agency::create([
            'agency_name' => $request->name,
            'abbreviation' => $request->abbr,
            'org_id' => $request->organization,
            'description' => $request->description,
        ]);
        
        return response()->json(['message'=>'Organization created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Agencies', 'url' => route('agencies.index'), 'active' => true],
            ['label' => 'Edit Agency', 'url' => route('agencies.edit', $agency->id), 'active' => true],
        ];         
        $organizations = Organization::pluck('org_name','id')->all();

        return view('auth.admin.agencies.edit', compact('agency', 'organizations', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'name'=>['required','string','min:5','max:80'],
            'organization' => ['required', 'exists:organizations,id']
        ], [
            'name.required' => 'Agency name is required.',
            'name.string' => 'Agency name must be a valid string.',
            'name.min' => 'Agency name must be at least 5 characters.',
            'organization.required' => 'Please select a organization.'
        ]); 

        $agency->update([
            'agency_name' => $request->name,
            'abbreviation' => $request->abbr,
            'org_id' => $request->organization,
            'description' => $request->description,
        ]);        
        
        return response()->json(['message'=>'Organization created successfully.'], 201);
    }

    public function destroy(string $id)
    {
        $agency = Agency::findOrFail($id);
        $agency->delete();
        return redirect('agencies')->with('status', 'Agency Deleted Successfully');
    }
}
