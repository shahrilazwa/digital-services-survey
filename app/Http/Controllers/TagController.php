<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Tags', 'url' => route('tags.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $tags = Tag::query();
        
        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $tags->where('name', 'like', '%' . $search . '%');
        }
        $tags = $tags->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

        return view('auth.admin.tags.index', compact('tags', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Tags', 'url' => route('tags.index'), 'active' => false],
            ['label' => 'Create Tags', 'url' => route('tags.create'), 'active' => true],
        ];

        return view('auth.admin.tags.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string','min:3','max:80'],
            'description' => ['nullable', 'string', 'max:255'],
        ], [
            'title.required' => 'Tag title is required.',
            'title.string' => 'Tag title must be a valid string.',
            'title.min' => 'Tag title must be at least 5 characters.',
        ]); 

        Tag::create([
            'name' => $request->title,
            'description' => $request->description,
        ]);
        
        return response()->json(['message'=>'Tag created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Tag $tag)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Tags', 'url' => route('tags.index'), 'active' => false],
            ['label' => 'Edit Tag', 'url' => route('tags.edit', $tag->id), 'active' => true],
        ];

        return view('auth.admin.tags.edit', compact('tag', 'breadcrumbs'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'title'=>['required','string','min:3','max:80'],
        ], [
            'title.required' => 'Tag name is required.',
            'title.string' => 'Tag name must be a valid string.',
            'title.min' => 'Tag name must be at least 3 characters.',
        ]); 

        $tag->update([
            'name' => $request->title,
            'description' => $request->description,
        ]);        
        
        return response()->json(['message'=>'Organization created successfully.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect('tags')->with('status', 'Tag Deleted Successfully');
    }
}
