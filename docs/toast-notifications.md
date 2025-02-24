# **Toast Notification Standards**

## **Overview**
This document outlines the **standardized approach** to implementing **toast notifications** for success, error, and info messages in the **Digital Services Survey** project.

### **Why Use Toast Notifications?**
Toast notifications are **non-blocking alerts** that inform users of success, failure, or no changes **without requiring additional interaction** (e.g., clicking "OK" on a pop-up). They provide **real-time feedback** after operations such as:
- ✅ **Creating a new record**
- ✅ **Updating an existing record (Only if changes are made)**
- ✅ **Handling cases where no changes are detected**
- ✅ **Deleting a record**

### **Objectives of This Standard**
By following this standard, we achieve:
1. **Consistent UI behavior** - Ensures a uniform user experience across all pages.
2. **Improved debugging** - Uses Laravel’s `Log::error()` to track errors efficiently.
3. **Separation of backend and frontend logic** - Backend stores messages in session flash data, while JavaScript handles notifications.
4. **Automatic session clearing** - Ensures messages **do not persist after being displayed**.
5. **Dynamic route management** - Uses Blade to pass Laravel routes dynamically to JavaScript, preventing hardcoded URLs.

---

## **1️⃣ Handling Notifications in Laravel Controllers**
In Laravel, **flash session messages** are used to store success, error, or info messages **only for the next request**. These messages should be retrieved and displayed when the user is redirected back to a page.

### **Converting Query Parameters to Session Messages**
When performing a **redirect**, messages are passed as **query parameters** (e.g., `?success=Message`). Before rendering the view, these messages are converted into **session flash messages**.

📂 **File:** `app/Http/Controllers/PermissionController.php`
```php
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

    // Convert query string messages into session flash messages
    foreach (['success', 'error', 'info'] as $type) {
        if ($request->has($type)) {
            session()->flash($type, $request->get($type));
        }
    }

    $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

    return view('auth.admin.permissions.index', compact('breadcrumbs', 'permissions', 'perPage', 'search'));
}
```

### **Explanation**
1. **Retrieves notifications from the query string** (`$request->has($type)`).
2. **Stores them in session flash messages** (`session()->flash($type, $request->get($type))`).
3. **These messages are available only for the next request**, ensuring they do not persist.

---

## **2️⃣ Storing Messages in Controller Actions**
Each controller method must handle messages consistently.

### **✅ Update (Edit) Function with Change Detection**
```php
public function update(Request $request, Permission $permission)
{
    try {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'unique:permissions,name,' . $permission->id],
            'group' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500']
        ]);

        $userId = Auth::id() ?? 0;

        // Manually check for changes
        $hasChanges = false;
        if (
            $permission->name !== $request->name ||
            $permission->group !== $request->group ||
            $permission->description !== $request->description
        ) {
            $hasChanges = true;
        }

        // If no changes detected, return an info response
        if (!$hasChanges) {
            return response()->json([
                'success' => false,
                'message' => "No changes detected. Permission '{$request->name}' was not updated.",
                'details' => $request->name,
                'id' => $request->id,                    
            ], 200);
        }

        // Update only if changes exist
        $permission->update([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'updated_by' => $userId,
        ]);

        ActivityLogger::log('Permission Updated', 'Permission', $request->id, [
            'title' => 'Permission Updated',
            'description' => "{$request->name} permission updated by " . (Auth::user()->name ?? 'System'),
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
```

---

## **3️⃣ Displaying Toast Notifications in Blade**
📂 **File:** `resources/views/auth/admin/permissions/index.blade.php`
```blade
@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')
    @vite('resources/js/vendors/toastify.js')
@endPushOnce
```

💡 **Reminder:** *Always include these in your Blade file to ensure Axios and Toastify are loaded properly!* 

```blade
<!-- BEGIN: Success Notification Content -->
<x-base.notification
    class="flex"
    id="success-notification-content"
    data-message="{{ session('success') }}"
>
    <x-base.lucide
        class="text-success"
        icon="CheckCircle"
    />
    <div class="ml-4 mr-4">
        <div class="font-medium">Success!</div>
        <div class="mt-1 text-slate-500">
            {{ session('success') }}
        </div>
    </div>
</x-base.notification>
<!-- END: Success Notification Content -->

<!-- BEGIN: Info Notification Content -->
<x-base.notification
    class="flex"
    id="info-notification-content"
    data-message="{{ session('info') }}"
>
    <x-base.lucide
        class="text-info"
        icon="Info"
    />
    <div class="ml-4 mr-4">
        <div class="font-medium">Info</div>
        <div class="mt-1 text-slate-500">
            {{ session('info') }}
        </div>
    </div>
</x-base.notification>    
<!-- END: Info Notification Content -->

<!-- BEGIN: Error Notification Content -->
<x-base.notification
    class="flex"
    id="error-notification-content"
    data-message="{{ session('error') }}"
>
    <x-base.lucide
        class="text-danger"
        icon="XCircle"
    />
    <div class="ml-4 mr-4">
        <div class="font-medium">Failed!</div>
        <div class="mt-1 text-slate-500">
            {{ session('error') }}
        </div>
    </div>
</x-base.notification>
<!-- END: Error Notification Content -->
```

---

## **Conclusion**
### **By following this standard, we ensure:**
✅ **Consistent UI behavior**  
✅ **Improved error debugging**  
✅ **Secure session handling** (clears messages after display)  
✅ **Separation of backend and frontend logic**  
✅ **Automatic session clearing via Axios**  
✅ **Correct detection of unchanged records and displaying of info toast notifications**  
✅ **Ensuring required JS libraries (Axios, Toastify) are included in the Blade file**
