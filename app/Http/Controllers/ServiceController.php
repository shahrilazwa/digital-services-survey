<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Services', 'url' => route('digital-services.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $services = Service::with('tags');
        
        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $services->where('service_name', 'like', '%' . $search . '%')
                ->orWhereHas('tags', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }
        $services = $services->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

        return view('auth.admin.digital-services.index', compact('services', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Services', 'url' => route('digital-services.index'), 'active' => false],
            ['label' => 'Create Services', 'url' => route('digital-services.create'), 'active' => true],
        ];
        $tags = Tag::pluck('name', 'id')->all();
        return view('auth.admin.digital-services.create', compact('breadcrumbs', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string','min:3','max:80'],
            'description' => ['nullable', 'string', 'max:255'],
            'tags' => ['exists:tags,id'],
        ], [
            'title.required' => 'Service title is required.',
            'title.string' => 'Service title must be a valid string.',
            'title.min' => 'Service title must be at least 5 characters.',
            'tags.exists' => 'One or more selected tags are invalid.',
        ]); 

        $service = Service::create([
            'service_name' => $request->title,
            'description' => $request->description,
        ]);

        $service->tags()->attach($request->tags);
        
        return response()->json(['message'=>'Service created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Service $digital_service)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Digital Services', 'url' => route('digital-services.index'), 'active' => false],
            ['label' => 'Update Service', 'url' => route('digital-services.edit', $digital_service->id), 'active' => true],
        ];
    
        $tags = Tag::pluck('name', 'id')->all();
        $serviceTags = $digital_service->tags->pluck('id')->toArray();
    
        return view('auth.admin.digital-services.edit', compact('breadcrumbs', 'digital_service', 'tags', 'serviceTags'));        
    }    

    public function update(Request $request, Service $digital_service)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:80'],
            'description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
        ]);
    
        // Update service
        $digital_service->update([
            'service_name' => $request->name,
            'description' => $request->description,
        ]);
    
        // Sync tags with the service
        $digital_service->tags()->sync($request->tags);
    
        return response()->json(['message' => 'Digital Service updated successfully.'], 201);
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->tags()->detach();
        $service->delete();

        return redirect()->route('digital-services.index')->with('status', 'Service deleted successfully.');
    }
}
