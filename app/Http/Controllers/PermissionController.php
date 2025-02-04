<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

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
            'name'=>['required','string','min:6','unique:permissions,name']
        ], [
            'name.required' => 'The permission name is required.',
            'name.string' => 'The permission name must be a valid string.',
            'name.min' => 'The permission name must be at least 6 characters.',
            'name.unique' => 'The permission name has already been taken. Please choose another name.',
        ]);
        Permission::create(['name'=>$request->name]);
        return response()->json(['message'=>'Permission created successfully.'], 201); 
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
            'name' => ['required', 'string', 'min:6', 'unique:permissions,name,' . $request->id],
        ], [
            'name.required' => 'The permission name is required.',
            'name.string' => 'The permission name must be a valid string.',
            'name.min' => 'The permission name must be at least 6 characters.',
            'name.unique' => 'The permission name has already been taken. Please choose another name.',
        ]);
        $permission->update(['name' => $request->name]);
        return response()->json(['message' => 'Permission updated successfully.'], 200);
    }

    public function destroy(string $id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect('permissions')->with('status', 'Permission Deleted Successfully');
    }
}
