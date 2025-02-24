<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view roles', ['only' => ['index']]);
        $this->middleware('permission:create roles', ['only' => ['create','store', 'addPermisssionToRole', 'givePermisssionToRole']]);
        $this->middleware('permission:update roles', ['only' => ['update','edit']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Roles', 'url' => route('roles.index'), 'active' => true],
        ];
        
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $roles = Role::query();

        if ($search) {
            $roles->where('name', 'like', '%' . $search . '%');
        }

        foreach (['success', 'error'] as $type) {
            if ($request->has($type)) {
                session()->flash($type, $request->get($type));
            }
        }

        $roles = $roles->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);          

        return view('auth.admin.roles.index', compact('breadcrumbs', 'roles', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Roles', 'url' => route('roles.index'), 'active' => false],
            ['label' => 'Create Role', 'url' => route('roles.create'), 'active' => true],
        ];        
        return view('auth.admin.roles.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'=>['required','string','min:6','unique:roles,name'],
                'description' => ['nullable', 'string', 'max:500']
            ], [
                'name.required' => 'The role name is required.',
                'name.string' => 'The role name must be a valid string.',
                'name.min' => 'The role name must be at least 6 characters.',
                'name.unique' => 'The role name has already been taken. Please choose another name.',
            ]);

            $userId = Auth::check() ? Auth::id() : 0;

            $role = Role::create([
                'name'=>$request->name,
                'description' => $request->description,
                'created_by' => $userId,
            ]);

            ActivityLogger::log('Role Created', 'Role', $role->id, [
                'title' => 'Role Created',
                'description' => $role->name . ' role created by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role created.', 
                'details' => $request->title,
                'id' => $request->id,
            ], 201);
        } catch (Exception $e) {
            // Log the detailed error
            Log::error('Role creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);

            return redirect()->route('role.index', [
                'error' => "Failed to create {$request->name} role."
            ]);            
        }            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Role $role)
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Roles', 'url' => route('roles.index'), 'active' => false],
            ['label' => 'Update Role', 'url' => route('roles.create'), 'active' => true],
        ]; 

        return view('auth.admin.roles.edit',compact('role', 'breadcrumbs'));
    }

    public function update(Request $request, Role $role)
    {
        // Force an error for testing purposes
        // throw new Exception("This is a test error for the error notification.");
        try {
            $request->validate([
                'name' => ['required', 'string', 'min:6', 'unique:roles,name,' . $request->id],
                'description' => ['nullable', 'string', 'max:500']
            ], 
            [
                'name.required' => 'The role name is required.',
                'name.string' => 'The role name must be a valid string.',
                'name.min' => 'The role name must be at least 6 characters.',
                'name.unique' => 'The role name has already been taken. Please choose another name.',
                'description.string' => 'The description must be a valid string.',
                'description.max' => 'The description cannot exceed 500 characters.'            
            ]);

            $userId = Auth::check() ? Auth::id() : 0; // Fallback to 0 if no user is authenticated

            $role->update([
                'name' => $request->name,
                'description' => $request->description,
                'updated_by' => $userId,
            ]); 

            ActivityLogger::log('Role Updated', 'Role', $request->id, [
                'title' => 'Role Updated',
                'description' => $request->name . ' role updated by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role updated.', 
                'details' => $request->title,
                'id' => $request->id,
            ], 201);
        } catch (Exception $e) {
            // Log the detailed error
            Log::error('Role update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permission_id' => $role->id
            ]);

            return response()->json([
                'success' => false,
                'message' => "Failed to update role {$request->name}.",
                'error' => $e->getMessage(),
            ], 500);
        }                  
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::findById($id);
            $roleName = $role->name;
            $role->delete();

            ActivityLogger::log('Role Deleted', 'Role', $role->id, [
                'title' => 'Role Deleted',
                'description' => $roleName . ' role deleted by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);      

            return redirect()->route('roles.index')->with('success', "Role {$roleName} deleted successfully.");
        } catch (Exception $e) {
            Log::error('Role delete failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'role_id' => $id
            ]);

            return redirect()->route('roles.index')->with('error', 'Failed to delete role.');
        }
    }

    public function addPermisssionToRole(Request $request, $roleId)
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'Roles', 'url' => route('roles.index'), 'active' => false],
            ['label' => 'Add Permission', 'url' => route('roles.create'), 'active' => true],
        ];
        
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $permissions = Permission::query();

        if ($search) {
            // Filter roles by the search term in the 'name' column
            $permissions->where('name', 'like', '%' . $search . '%');
        }

        $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);        

        // $permissions = Permission::get();
        $role = Role::findById($roleId);
        $rolePermissions = $role->permissions->pluck('id','id')->all();
        return view('auth.admin.roles.add-permissions', compact(
            'breadcrumbs',
            'role', 
            'permissions',
            'perPage',
            'search', 
            'rolePermissions'
        ));
    }

    public function givePermisssionToRole(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission added to role');
    }
}
