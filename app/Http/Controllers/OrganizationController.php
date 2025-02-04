<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Organizations', 'url' => route('organizations.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $organizations = Organization::withCount('agencies');

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $organizations->where('org_name', 'like', '%' . $search . '%');
        }

        $organizations = $organizations->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

        return view('auth.admin.organizations.index', compact('organizations', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Organizations', 'url' => route('organizations.index'), 'active' => false],
            ['label' => 'Create Organizations', 'url' => route('organizations.create'), 'active' => true],
        ];
        
        $orgTypes = Organization::TYPES;

        return view('auth.admin.organizations.create', compact('breadcrumbs', 'orgTypes'));
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:80'],
            'abbr' => ['nullable', 'string', 'max:10'],
            'type' => 'required|in:' . implode(',', array_keys(Organization::TYPES)),
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Organization name is required.',
            'name.string' => 'Organization name must be a valid string.',
            'name.min' => 'Organization name must be at least 5 characters.',
            'type.required' => 'Organization type is required.',
        ]);
    
        // Create the organization
        $organization = Organization::create([
            'org_name' => $request->name,
            'abbreviation' => $request->abbr,
            'type' => $request->type,
            'description' => $request->description,
        ]);
    
        return response()->json(['message' => 'Organization created successfully.'], 201);
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Organization $organization)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Organizations', 'url' => route('organizations.index'), 'active' => false],
            ['label' => 'Edit Organization', 'url' => route('organizations.edit', $organization->id), 'active' => true],
        ];
        
        $orgTypes = Organization::TYPES;
        return view('auth.admin.organizations.edit', compact('breadcrumbs', 'organization', 'orgTypes'));
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name'=>['required','string','min:5','max:80'],
            'type' => 'required|in:' . implode(',', array_keys(Organization::TYPES)),
        ], [
            'name.required' => 'Organization name is required.',
            'name.string' => 'Organization name must be a valid string.',
            'name.min' => 'Organization name must be at least 5 characters.',
            'type.required' => 'Organization type is required.',
        ]); 
        $organization->update([
            'org_name' => $request->name,
            'abbreviation' => $request->abbr,
            'type' => $request->type,
            'description' => $request->description,            
        ]);
        return response()->json(['message' => 'Organization updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organizations = Organization::findOrFail($id);
        $organizations->delete();
        return redirect('ministries')->with('status', 'Organizations Deleted Successfully');
    }
}
