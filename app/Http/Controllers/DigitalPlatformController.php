<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Service;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\DigitalPlatform;

class DigitalPlatformController extends Controller
{

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Platform', 'url' => route('digital-platforms.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');        
        $digitalPlatforms = DigitalPlatform::with(['organization', 'agency']);

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $digitalPlatforms->where('platform_name', 'like', '%' . $search . '%');
        }

        $digitalPlatforms = $digitalPlatforms->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);        

        return view('auth.admin.digital-platforms.index', compact('digitalPlatforms', 'breadcrumbs', 'perPage', 'search'));
    }
    

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Platform', 'url' => route('digital-platforms.index'), 'active' => false],
            ['label' => 'Create Platform', 'url' => route('digital-platforms.create'), 'active' => true],
        ];

        $organizations = Organization::pluck('org_name', 'id')->all();
        $agencies = Agency::pluck('agency_name', 'id')->all();
        $digitalServices = Service::all();
        $platformTypes = DigitalPlatform::TYPES;
        $eaClusters = DigitalPlatform::EA_CLUSTERS;
        return view('auth.admin.digital-platforms.create', compact('organizations', 'agencies', 'digitalServices', 'platformTypes', 'eaClusters', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:80'],
            'abbr' => ['nullable', 'string', 'max:20'],
            'type' => 'required|in:' . implode(',', array_keys(DigitalPlatform::TYPES)),
            'cluster' => 'required|in:' . implode(',', array_keys(DigitalPlatform::EA_CLUSTERS)),
            'url' => ['required', 'url'],
            'digitalServices' => ['required', 'array', 'exists:services,id'],
            'organization' => ['nullable', 'exists:organizations,id'],
            'agency' => ['nullable', 'exists:agencies,id'],
        ]);

        
        // Create application with determined type and owner ID
        $digitalPlatform = DigitalPlatform::create([
            'platform_name' => $request->name,
            'abbreviation' => $request->abbr,
            'type' => $request->type,
            'ea_cluster' => $request->cluster,
            'url' => $request->url,
            'description' => $request->desc,
            'agency_id' => $request->agency,
            'org_id' => $request->organization,
        ]);
    
        // Sync digital services
        $digitalPlatform->services()->sync($request->digitalServices);

        return response()->json([
            'message' => 'Record created!', 
            'details' => $digitalPlatform->platform_name
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(DigitalPlatform $digital_platform)
    {
        $digital_platform->load('services');

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Platform', 'url' => route('digital-platforms.index'), 'active' => false],
            ['label' => 'Edit Platform', 'url' => route('digital-platforms.edit', $digital_platform->id), 'active' => true],
        ];
        
        $organizations = Organization::pluck('org_name', 'id')->all();
        $agencies = Agency::pluck('agency_name', 'id')->all();
        $digitalServices = Service::all();
        $platformTypes = DigitalPlatform::TYPES;
        $eaClusters = DigitalPlatform::EA_CLUSTERS;

        return view('auth.admin.digital-platforms.edit', compact('digital_platform', 'organizations', 'agencies', 'digitalServices', 'platformTypes', 'eaClusters', 'breadcrumbs'));
    }

    public function update(Request $request, DigitalPlatform $digitalPlatform)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'abbr' => 'nullable|string|max:10',
            'url' => 'required|url',
            'type' => 'required|array',
            'type.*' => 'string|in:' . implode(',', array_keys(DigitalPlatform::TYPES)),
            'desc' => 'nullable|string|max:255',
            'cluster' => 'required|array',
            'cluster.*' => 'string|in:' . implode(',', array_keys(DigitalPlatform::EA_CLUSTERS)),
            'owner' => 'required|string|in:agency,organization',
            'agency' => 'nullable|exists:agencies,id|required_if:owner,agency',
            'organization' => 'nullable|exists:organizations,id|required_if:owner,organization',
            'digitalServices' => 'nullable|array',
            'digitalServices.*' => 'exists:services,id',
        ]);
    
        // Update the digital platform's basic information
        $digitalPlatform->update([
            'platform_name' => $validated['name'],
            'abbreviation' => $validated['abbr'],
            'url' => $validated['url'],
            'type' => $validated['type'][0],
            'description' => $validated['desc'],
            'ea_cluster' => $validated['cluster'][0],
        ]);
    
        // Update ownership
        if ($validated['owner'] === 'agency') {
            $digitalPlatform->update([
                'agency_id' => $validated['agency'],
                'org_id' => null, // Clear organization if switched to agency
            ]);
        } elseif ($validated['owner'] === 'organization') {
            $digitalPlatform->update([
                'org_id' => $validated['organization'],
                'agency_id' => null, // Clear agency if switched to organization
            ]);
        }
    
        // Sync digital services
        if (isset($validated['digitalServices'])) {
            $digitalPlatform->services()->sync($validated['digitalServices']);
        } else {
            $digitalPlatform->services()->detach(); // Remove all services if none provided
        }
    
        // Redirect back with success message
        return response()->json([
            'message' => 'Record updated!', 
            'details' => $digitalPlatform->platform_name
        ], 201);
                        
    }
    

    public function destroy(string $id)
    {
        // Find the platform or throw a 404 error if not found
        $platform = DigitalPlatform::findOrFail($id);
    
        $platform->services()->detach();
        $platform->delete();
    
        // Redirect to the index page with a success message
        return redirect()->route('digital-platforms.index')->with('status', 'Record deleted!');
    }
    
}
