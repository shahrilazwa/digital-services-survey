# **Toast Notification Standards**

## **Overview**
This document establishes the **standardized approach** to implementing **toast notifications** for success and error messages in the **Digital Services Survey** project.

Toast notifications provide **real-time feedback** to users after performing operations like:
- ✅ **Creating a new record**
- ✅ **Updating an existing record**
- ✅ **Deleting a record**

By following this standard, we ensure:
- **Consistent UI behavior** across the application.
- **Improved debugging** using Laravel's `Log::error()`.
- **Separation of backend and frontend logic** for maintainability.
- **Dynamic route management** using Blade.

---

## **Notification Types**
The system supports two types of notifications:

| Notification Type | Description | Example |
|------------------|-------------|---------|
| **Success** ✅ | Displayed when an operation **completes successfully**. | `"Permission 'Admin Access' created successfully."` |
| **Error** ❌ | Displayed when an **operation fails** due to validation errors or exceptions. | `"Failed to update permission 'User Read'."` |

---

## **Standard Implementation in Laravel Controllers**
### **1. Converting Query Parameters to Session Messages**
In the `index` function, we convert **query string messages** into session flash messages.

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
    foreach (['success', 'error'] as $type) {
        if ($request->has($type)) {
            session()->flash($type, $request->get($type));
        }
    }

    $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

    return view('auth.admin.permissions.index', compact('breadcrumbs', 'permissions', 'perPage', 'search'));
}
```

---

### **2. Storing Messages in Controllers**
Each controller method should follow a structured approach to handling success and error messages.

#### ✅ **Create (Store) Function**
```php
public function store(Request $request)
{
    try {
        $request->validate([
            'name' => ['required', 'string', 'min:6', 'unique:permissions,name'],
            'group' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500']
        ]);

        $userId = Auth::id() ?? 0;

        $permission = Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'created_by' => $userId,
        ]);

        ActivityLogger::log('Created', 'Permission', $permission->id, [
            'title' => 'Permission Created',
            'description' => "{$permission->name} permission created by " . (Auth::user()->name ?? 'System'),
        ]);

        return redirect()->route('permissions.index', [
            'success' => "Permission '{$permission->name}' created successfully."
        ]);

    } catch (Exception $e) {
        Log::error('Permission creation failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $request->all(),
        ]);

        return redirect()->route('permissions.index', [
            'error' => "Failed to create permission '{$request->name}'."
        ]);
    }
}
```

#### ✅ **Update Function**
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

        $permission->update([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'updated_by' => $userId,
        ]);

        ActivityLogger::log('Updated', 'Permission', $permission->id, [
            'title' => 'Permission Updated',
            'description' => "{$permission->name} permission updated by " . (Auth::user()->name ?? 'System'),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' updated successfully.",
        ]);

    } catch (Exception $e) {
        Log::error('Permission update failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'permission_id' => $permission->id,
        ]);

        return response()->json([
            'success' => false,
            'error' => "Failed to update permission '{$request->name}'."
        ], 500);
    }
}
```

---

### **3. Blade Template for Displaying Messages**
📂 **File:** `resources/views/auth/admin/permissions/index.blade.php`
```blade
@foreach (['success', 'error'] as $type)
    @if (session($type))
        <div id="{{ $type }}-message" data-message="{{ session($type) }}"></div>
    @endif
@endforeach
```
This ensures notifications are dynamically displayed without redundant code.

---

### **4. Toast Notification in JavaScript**
📂 **File:** `resources/js/pages/listPermission.js`
```js
(function () {
    "use strict";

    function showToast(elementId, contentId) {
        let messageElement = $(`#${elementId}`);
        if (messageElement.length > 0) {
            Toastify({
                node: $(`#${contentId}`).clone().removeClass("hidden")[0],
                duration: -1,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            // Clear session data after displaying the notification
            messageElement.remove();
        }
    }

    // Show success and error notifications
    showToast("success-message", "success-notification-content");
    showToast("error-message", "error-notification-content");

})();
```

---

## **5. Using Dynamic Routes in JavaScript**
To **avoid hardcoding URLs**, Blade can dynamically pass route values to JavaScript.

📂 **File:** `resources/views/auth/admin/permissions/edit.blade.php`
```blade
@pushOnce('scripts')
    <script>
        window.routes = {
            permissionsIndex: @json(route('permissions.index'))
        };
    </script>

    @vite('resources/js/pages/editPermission.js')
@endPushOnce
```

📂 **File:** `resources/js/pages/editPermission.js`
```js
window.location.href = `${window.routes.permissionsIndex}?success=Permission '${formData.name}' updated successfully.`;
```

---

## **Summary of the Standard**
| Component | Standard |
|------------|-------------|
| **Success/Error Messages** | Stored in **session flash messages** |
| **JavaScript Handling** | Uses `Toastify.js` for **automatic detection** |
| **Logging Errors** | Always use `Log::error()` in `catch` blocks |
| **Tracking Activities** | Use `ActivityLogger::log()` to track changes |
| **Redirecting After Action** | Pass messages via query parameters |
| **Dynamic Routes** | Use `window.routes` to avoid hardcoding URLs |
| **Clearing Notifications** | Session messages are removed after display |

---

## **Conclusion**
By following this **standardized approach**, we ensure:
- ✅ **Consistent UI behavior**
- ✅ **Better error debugging**
- ✅ **Secure handling of success and error messages**
- ✅ **Efficient activity tracking using logs**
- ✅ **Dynamic route management for maintainability**

For further modifications, contact the **Survey Admin**.
```
