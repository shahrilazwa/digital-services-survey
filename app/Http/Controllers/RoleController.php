<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            // Filter roles by the search term in the 'name' column
            $roles->where('name', 'like', '%' . $search . '%');
        }

        $roles = $roles->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);          

        return view('auth.admin.roles.index', compact('roles', 'breadcrumbs', 'perPage', 'search'));
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
        $request->validate([
            'name'=>['required','string','min:6','unique:roles,name']
        ], [
            'name.required' => 'The role name is required.',
            'name.string' => 'The role name must be a valid string.',
            'name.min' => 'The role name must be at least 6 characters.',
            'name.unique' => 'The role name has already been taken. Please choose another name.',
        ]);
        Role::create(['name'=>$request->name]);
        return response()->json(['message'=>'Role created successfully.'], 201); 
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
        $request->validate(['name' => ['required', 'string', 'min:6', 'unique:roles,name,' . $request->id]], 
        [
            'name.required' => 'The role name is required.',
            'name.string' => 'The role name must be a valid string.',
            'name.min' => 'The role name must be at least 6 characters.',
            'name.unique' => 'The role name has already been taken. Please choose another name.',
        ]);
        $role->update(['name' => $request->name]);
        return response()->json(['message' => 'Permission updated successfully.'], 200);        
    }

    public function destroy(string $id)
    {
        
        $role = Role::findById($id);
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted Successfully');
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
