# **Toast Notification Standards**

## **Overview**
This document outlines the **standardized approach** to implementing **toast notifications** for success and error messages in the **Digital Services Survey** project. 

### **Why Use Toast Notifications?**
Toast notifications are **non-blocking alerts** that inform users of success or failure **without requiring additional interaction** (e.g., clicking "OK" on a pop-up). They provide **real-time feedback** after operations such as:
- ✅ **Creating a new record**
- ✅ **Updating an existing record**
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
In Laravel, **flash session messages** are used to store success or error messages **only for the next request**. These messages should be retrieved and displayed when the user is redirected back to a page.

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
    foreach (['success', 'error'] as $type) {
        if ($request->has($type)) {
            session()->flash($type, $request->get($type));
        }
    }

    $permissions = $permissions->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);

    return view('auth.admin.permissions.index', compact('breadcrumbs', 'permissions', 'perPage', 'search'));
}
```

### **Explanation**
1. **Retrieves notifications from the query string** (`$request->has($type)`)
2. **Stores them in session flash messages** (`session()->flash($type, $request->get($type))`)
3. **These messages are available only for the next request**, ensuring they do not persist.

---

## **2️⃣ Storing Messages in Controller Actions**
Each controller method must handle messages consistently.

### **✅ Create (Store) Function**
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
### **Key Aspects**
1. **Validation** - Ensures required fields are present before proceeding.
2. **Error Handling** - If an exception occurs, it is logged (`Log::error()`) and an **error message is sent via redirect**.
3. **Activity Logging** - Every successful creation is recorded using `ActivityLogger::log()`.
4. **Redirects with Flash Message** - Redirects back to `permissions.index` with a `success` or `error` message.

---

## **3️⃣ Displaying Toast Notifications in Blade**
📂 **File:** `resources/views/auth/admin/permissions/index.blade.php`
```blade
@foreach (['success', 'error'] as $type)
    @if (session($type))
        <div id="{{ $type }}-message" data-message="{{ session($type) }}"></div>
    @endif
@endforeach
```
### **How This Works**
- The **Blade template dynamically checks** for both success and error messages.
- If found, it **creates a hidden `div` element** that is later read by JavaScript.

---

## **4️⃣ Toast Notification in JavaScript**
📂 **File:** `resources/js/pages/listPermission.js`
```js
(function () {
    "use strict";

    // Delete confirmation
    $("#delete-button").on("click", function () {
        Toastify({
            node: $("#delete-confirmation")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });

    // Function to show Toast notifications and clear session values
    function showToastAndClearSession(type, messageElementId, notificationElementId) {
        let messageElement = $(`#${messageElementId}`);
        if (messageElement.length > 0) {  
            Toastify({
                node: $(`#${notificationElementId}`)
                    .clone()
                    .removeClass("hidden")[0],
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                callback: function () {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }).showToast();

            clearSessionMessage(messageElementId);
        }
    }

    function clearSessionMessage(sessionKey) {
        axios.post("/clear-session-message", { key: sessionKey })
            .then(response => console.log(`Session key '${sessionKey}' cleared.`))
            .catch(error => console.error(`Failed to clear session key '${sessionKey}':`, error));
    }

    // Show and clear success notification
    showToastAndClearSession("success", "success-message", "success-notification-content");

    // Show and clear error notification
    showToastAndClearSession("error", "error-message", "error-notification-content");

})();
```

### **How This Works**
1. **Toastify.js is used to display notifications**.
2. **Session messages are retrieved from Blade (`#success-message`, `#error-message`)**.
3. **The notification disappears after 3 seconds (`duration: 3000`)**.
4. **Session messages are cleared after the notification is displayed** using an **Axios POST request**.

---

## **5️⃣ Laravel Route for Clearing Session Messages**
📂 **File:** `routes/web.php`
```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::post('/clear-session-message', function (Request $request) {
    $key = $request->input('key');
    if ($key && Session::has($key)) {
        Session::forget($key);
    }
    return response()->json(['success' => true]);
});
```
### **Purpose**
- This route allows the frontend to **clear session messages via Axios**.
- Once a toast notification is displayed, it sends a POST request to remove the session key.

---

## **Conclusion**
### **By following this standard, we ensure:**
✅ **Consistent UI behavior**  
✅ **Improved error debugging**  
✅ **Secure session handling** (clears messages after display)  
✅ **Separation of backend and frontend logic**  
✅ **Automatic session clearing via Axios**  

For further inquiries, contact the **Survey Admin** or **Super Admin**. 🚀
