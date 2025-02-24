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
            $permissions->where('name', 'like', '%' . $search . '%');
        }
    
        foreach (['success', 'error', 'info'] as $type) {
            if ($request->has($type)) {
                session()->flash($type, $request->get($type));
            }
        }
    
        $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);        
    
        return view('auth.admin.permissions.index', compact(
            'breadcrumbs',
            'permissions',
            'perPage',
            'search',
        ));
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
        try {
            // Force an error for testing purposes
            // throw new Exception("This is a test error for the error notification.");

            $request->validate([
                'name' => ['required', 'string', 'min:6', 'unique:permissions,name'],
                'group' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:500']
            ]);
    
            $userId = Auth::check() ? Auth::id() : 0;
    
            $permission = Permission::create([
                'name' => $request->name,
                'group' => $request->group,
                'description' => $request->description,
                'created_by' => $userId,
            ]);
    
            ActivityLogger::log('Permission Created', 'Permission', $permission->id, [
                'title' => 'Permission Created',
                'description' => $permission->name . ' permission created by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permission created.', 
                'details' => $request->title,
                'id' => $request->id,
            ], 201);            
        
        } catch (Exception $e) {
            // Log the detailed error
            Log::error('Permission creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);

            return redirect()->route('permissions.index', [
                'error' => "Failed to create {$request->name} permission."
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
        // Force an error for testing purposes
        // throw new Exception("This is a test error for the error notification.");
        
        try {
            $request->validate([
                'name' => ['required', 'string', 'min:6', 'unique:permissions,name,' . $permission->id],
                'group' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:500']
            ]);
    
            $userId = Auth::check() ? Auth::id() : 0; // Fallback to 0 if no user is authenticated
    
            // Compare each field manually to detect changes
            $hasChanges = false;
            if (
                $permission->name !== $request->name ||
                $permission->group !== $request->group ||
                $permission->description !== $request->description
            ) {
                $hasChanges = true;
            }
    
            // If no changes were detected, return info response
            if (!$hasChanges) {
                return response()->json([
                    'success' => false,
                    'message' => "No changes detected. Permission '{$request->name}' was not updated.",
                    'details' => $request->name,
                    'id' => $request->id,                    
                ], 200);
            }
    
            // Update only if changes are detected
            $permission->update([
                'name' => $request->name,
                'group' => $request->group,
                'description' => $request->description,
                'updated_by' => $userId,
            ]);
    
            ActivityLogger::log('Permission Updated', 'Permission', $request->id, [
                'title' => 'Permission Updated',
                'description' => $request->name . ' permission updated by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);        
    
            return response()->json([
                'success' => true,
                'message' => "Permission '{$request->name}' updated successfully.",
                'details' => $request->name,
                'id' => $request->id,
            ], 201);
        } catch (Exception $e) {
            Log::error('Permission update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permission_id' => $permission->id
            ]);
    
            return response()->json([
                'success' => false,
                'message' => "Failed to update permission '{$request->name}'.",
                'error' => $e->getMessage(),
            ], 500);
        }           
    }

    public function destroy(string $id)
    {
        try {
            $permission = Permission::findById($id);
            $permissionName = $permission->name;
            $permission->delete();

            ActivityLogger::log('Permission Deleted', 'Permission', $permission->id, [
                'title' => 'Permission Deleted',
                'description' => $permissionName . ' permission deleted by ' . (Auth::check() ? Auth::user()->name : 'System'),
            ]);      

            return redirect()->route('permissions.index')->with('success', "Permission {$permissionName} deleted successfully.");
        } catch (Exception $e) {
            Log::error('Permission delete failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permission_id' => $id
            ]);

            return redirect()->route('permissions.index')->with('error', 'Failed to delete permission.');
        }            
    }
}
