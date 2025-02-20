# **Toast Notification Standards**

## **1️⃣ Overview**
This document establishes the **standardized approach** to implementing **toast notifications** for success and error messages in the **Digital Services Survey** project. 

Toast notifications are used to provide **real-time user feedback** after performing operations like:
- ✅ **Creating a new record**
- ✅ **Updating an existing record**
- ✅ **Deleting a record**

By following this standard, we ensure:
- **Consistent UI behavior** across the application.
- **Improved debugging** using Laravel's `Log::error()`.
- **Separation of backend and frontend logic** for maintainability.
- **Dynamic route management** using Blade.

---

## **2️⃣ Notification Types**
There are two types of toast notifications:

| Notification Type | Description | Example |
|------------------|-------------|---------|
| **Success** ✅ | Shown when an operation **completes successfully**. | `"Permission 'Admin Access' created successfully."` |
| **Error** ❌ | Displayed when an **operation fails** due to validation errors or exceptions. | `"Failed to update permission 'User Read'."` |

---

## **3️⃣ Standard Implementation in Laravel Controllers**
Each function in a controller **must**:
1. **Use a `try-catch` block** to handle exceptions.
2. **Log errors** using Laravel’s `Log::error()` for debugging.
3. **Use `ActivityLogger::log()`** to track user actions.
4. **Redirect with success/error messages** as query parameters.
5. **Convert query parameters into session messages** before rendering the view.

---

### **1. Storing Success & Error Messages in the Controller**
In the `index` function of your controller, convert **query string messages** into session flash messages.

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

    return view('auth.admin.permissions.index', [
        'breadcrumbs' => $breadcrumbs,
        'permissions' => $permissions,
        'perPage' => $perPage,
        'search' => $search,
    ]);
}
```
---

### **2. Handling Toast Notifications in Blade**
Use the following **Blade template** to automatically display notifications if they exist in the session.

📂 **File:** `resources/views/auth/admin/permissions/index.blade.php`
```blade
@foreach (['success', 'error'] as $type)
    @if (session($type))
        <div id="{{ $type }}-message" data-message="{{ session($type) }}"></div>
    @endif
@endforeach
```

This **ensures** that notifications are **handled dynamically** and do not require separate `if` statements for each type.

---

### **3. Storing Messages in Controllers**
Each function in a controller should handle messages consistently.

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

        $userId = Auth::check() ? Auth::id() : 0;

        $permission = Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'description' => $request->description,
            'created_by' => $userId,
        ]);

        ActivityLogger::log('Created', 'Permission', $permission->id, [
            'title' => 'Permission Created',
            'description' => "{$permission->name} permission created by " . (Auth::check() ? Auth::user()->name : 'System'),
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
---

### **4. Implementing Toast Notifications in JavaScript**
Toast notifications **automatically detect** session messages and **display them as alerts**.

📂 **File:** `resources/js/pages/listPermission.js`
```js
(function () {
    "use strict";

    // Success notification
    let successMessageElement = $("#success-message");
    if (successMessageElement.length > 0) {  
        Toastify({
            node: $("#success-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    }

    // Error notification
    let errorMessageElement = $("#error-message");
    if (errorMessageElement.length > 0) {  
        Toastify({
            node: $("#error-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    }

})();
```
---

## **5️⃣ Using Dynamic Routes in JavaScript**
To **avoid hardcoding routes** in JavaScript, we **store routes dynamically** in Blade before loading JavaScript files.

### **Blade Dynamic Route Setup**
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

### **Using Dynamic Routes in JavaScript**
📂 **File:** `resources/js/pages/editPermission.js`
```js
window.location.href = `${window.routes.permissionsIndex}?success=Permission '${formData.name}' updated successfully.`;
```
This ensures **future route changes** will automatically be applied to JavaScript without requiring updates in multiple places.

---

## **6️⃣ Summary of the Standard**
| Component | Standard |
|------------|-------------|
| **Success/Error Messages** | Stored in **session flash messages** |
| **JavaScript Handling** | Uses `Toastify.js` for **automatic detection** |
| **Logging Errors** | Always use `Log::error()` in `catch` blocks |
| **Tracking Activities** | Use `ActivityLogger::log()` to track changes |
| **Redirecting After Action** | Pass messages via query parameters |
| **Dynamic Routes** | Use `window.routes` to avoid hardcoding URLs |

---

## **7️⃣ Conclusion**
By following this **standardized approach**, we ensure:
- ✅ **Consistent UI behavior**
- ✅ **Better error debugging**
- ✅ **Secure handling of success and error messages**
- ✅ **Efficient activity tracking using logs**
- ✅ **Dynamic route management for maintainability**

For further modifications, contact the **Survey Admin**.
```
