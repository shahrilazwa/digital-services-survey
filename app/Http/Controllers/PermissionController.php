<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Helpers\ActivityLogger;
use Exception;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permissions', ['only' => ['index']]);
        $this->middleware('permission:create permissions', ['only' => ['create','store']]);
        $this->middleware('permission:update permissions', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Permission', 'url' => route('permissions.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $permissions = Permission::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $permissions->where('name', 'like', '%' . $search . '%');
        }

        $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);        

        return view('auth.admin.permissions.index', [
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions,
            'perPage' => $perPage,
            'search' => $search,
        ]);
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Permission', 'url' => route('permissions.index'), 'active' => false],
            ['label' => 'Create Permission', 'url' => route('permissions.create'), 'active' => true],
        ];
        return view('auth.admin.permissions.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'unique:permissions,name'],
            'group' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500']
        ], [
            'name.required' => 'The permission name is required.',
            'name.string' => 'The permission name must be a valid string.',
            'name.min' => 'The permission name must be at least 6 characters.',
            'name.unique' => 'The permission name has already been taken. Please choose another name.',
            'group.string' => 'The permission group must be a valid string.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description cannot exceed 500 characters.'
        ]);

        $userId = Auth::check() ? Auth::id() : 0; // Fallback to 0 if no user is authenticated

        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'created_by' => $userId,
        ]);

        ActivityLogger::log('Created', 'Permission', $request->id, [
            'title' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created.', 
            'details' => $request->title,
            'id' => $request->id,
        ], 201);        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Permission $permission)
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Permission', 'url' => route('permissions.index'), 'active' => false],
            ['label' => 'Update Permission', 'url' => route('permissions.edit', $permission->id), 'active' => true],
        ];
        return view('auth.admin.permissions.edit',[
            'permission' => $permission,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function update(Request $request, Permission $permission)
    {  
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'unique:permissions,name,' . $permission->id],
            'group' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500']
        ], [
            'name.required' => 'The permission name is required.',
            'name.string' => 'The permission name must be a valid string.',
            'name.min' => 'The permission name must be at least 6 characters.',
            'name.unique' => 'The permission name has already been taken. Please choose another name.',
            'group.string' => 'The permission group must be a valid string.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description cannot exceed 500 characters.'
        ]);

        $userId = Auth::check() ? Auth::id() : 0; // Fallback to 0 if no user is authenticated

        $permission->update([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'updated_by' => $userId,
        ]);

        ActivityLogger::log('Updated', 'Permission', $request->id, [
            'title' => $request->name,
            'description' => $request->description,
        ]);        

        return response()->json([
            'success' => true,
            'message' => 'Permission updated.', 
            'details' => $request->title,
            'id' => $request->id,
        ], 201);         
    }

    public function destroy(string $id)
    {
        try {
            $permission = Permission::findById($id);
            $permission->delete();

            ActivityLogger::log('Created', 'Permission', $permission->id, [
                'title' => $permission->name,
                'description' => $permission->description,
            ]);      

            return redirect()->route('permissions.index')->with('success', 'Permission Deleted Successfully.');
        } catch (Exception $e) {
            // Log the detailed error
            Log::error('Permission delete failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permission_id' => $permission->id
            ]);

            return redirect()->route('schemas.index')->with('error', 'Failed to delete schema and its associated records.');
        }            
    }
}
