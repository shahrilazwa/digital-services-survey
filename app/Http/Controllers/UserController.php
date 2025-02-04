<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agency;
use App\Models\Organization;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users', ['only' => ['index']]);
        $this->middleware('permission:create users', ['only' => ['create','store']]);
        $this->middleware('permission:update users', ['only' => ['update','edit']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }    

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'User', 'url' => route('users.index'), 'active' => true],
        ];

        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $users = User::query();

        if ($search) {
            // Filter permissions by the search term in the 'name' column
            $users->where('name', 'like', '%' . $search . '%');
        }

        $users = $users->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);         

        return view('auth.admin.users.index', compact('users', 'breadcrumbs', 'perPage', 'search'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'User', 'url' => route('users.index'), 'active' => false],
            ['label' => 'Create User', 'url' => route('users.create'), 'active' => true],
        ];        
        $roles = Role::pluck('name','name')->all();
        $userTypes = User::TYPES;
        $organizations = Organization::pluck('org_name', 'id')->all();
        $agencies = Agency::pluck('agency_name', 'id')->all();        
        return view('auth.admin.users.create', compact('roles', 'breadcrumbs', 'userTypes', 'organizations', 'agencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:80'],
            'email' => ['required', 'email', 'min:6', 'unique:users,email'],
            'personal_email' => ['required', 'email', 'min:6', 'unique:users,personal_email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'user_type' => 'required|in:' . implode(',', array_keys(User::TYPES)),
            'placement' => ['required', 'in:organization,agency'],
            'agency_id' => 'nullable|exists:agencies,id|required_if:placement,agency',
            'org_id' => 'nullable|exists:organizations,id|required_if:placement,organization',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ], [
            'name.required' => 'User name is required.',
            'email.required' => 'Official email is required.',
            'personal_email.required' => 'Personal email is required.',
            'password.required' => 'Password is required.',
            'user_type.required' => 'User type is required.',
            'placement.required' => 'User placement (organization or agency) is required.'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'personal_email' => $request->personal_email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'org_id' => $request->placement === 'organization' ? $request->org_id : null,
            'agency_id' => $request->placement === 'agency' ? $request->agency_id : null
        ]);
    
        $user->syncRoles($request->roles);
    
        return response()->json(['message' => 'User created successfully.'], 201);
    }       
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false],
            ['label' => 'User', 'url' => route('users.index'), 'active' => false],
            ['label' => 'Update User', 'url' => route('users.edit', $user->id), 'active' => true],
        ];
        $placement = $user->org_id ? 'organization' : ($user->agency_id ? 'agency' : null);  
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $userTypes = User::TYPES;
        $organizations = Organization::pluck('org_name', 'id')->all();
        $agencies = Agency::pluck('agency_name', 'id')->all();        
        
        return view('auth.admin.users.edit', compact(
            'roles',
            'breadcrumbs',
            'user',
            'placement',
            'userTypes',
            'organizations', 
            'agencies',    
        ));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:80'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'personal_email' => ['required', 'email', 'min:6', 'unique:users,personal_email,' . $user->id],
            'roles' => ['required', 'array'],
            'user_type' => 'required|in:' . implode(',', array_keys(User::TYPES)),
            'placement' => ['required', 'in:organization,agency'],
            'agency_id' => 'nullable|exists:agencies,id|required_if:placement,agency',
            'org_id' => 'nullable|exists:organizations,id|required_if:placement,organization',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ], [
            'name.required' => 'User name is required.',
            'email.unique' => 'Email is already in use by another user.',
            'email.required' => 'Official email is required.',
            'personal_email.required' => 'Personal email is required.',
            'user_type.required' => 'User type is required.',
            'placement.required' => 'User placement (organization or agency) is required.',
            'roles.required' => 'At least one role must be assigned.',
        ]);
    
        // Prepare update data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'personal_email' => $request->personal_email,
            'user_type' => $request->user_type,
            'org_id' => $request->placement === 'organization' ? $request->org_id : null,
            'agency_id' => $request->placement === 'agency' ? $request->agency_id : null,
        ];
    
        // Update user and sync roles
        $user->update($data);
        $user->syncRoles($request->roles);
    
        return response()->json(['message' => 'User updated successfully.'], 201);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('users')->with('status', 'User Deleted Successfully');
    }     
}
