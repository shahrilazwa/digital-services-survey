# 📜 **Guide to Creating a New Form**

## **Overview**
Forms are an essential part of any web application, allowing users to submit data such as **creating users, permissions, surveys, or responses**. In the **Digital Services Survey System**, form creation follows a structured approach using **Blade components** to ensure **consistent design, validation, and interactivity**.

This guide will walk through:

✔️ **Setting Up the Form Blade File**  
✔️ **Using Standard Blade Components** (`x-base.form-inline`, `x-base.form-label`, `x-base.form-input`, etc.)  
✔️ **Handling Form Submission with Axios**  
✔️ **Processing the Form Request in Laravel**  
✔️ **Returning JSON Responses & Showing Toast Notifications**  

---

## 📌 **1️⃣ Creating the Blade File for the Form**
Each form should follow the **standard templating structure**.

### **🔹 Example Form File Structure**
The form will be stored in `resources/views/auth/admin/[entity]/create.blade.php`.  
For example, if creating a **new permission**, the form file should be:

📂 `resources/views/auth/admin/permissions/create.blade.php`

### **🔹 Form Blade Template**
```blade
@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Create Permission</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Create Permission</h2>
    </div>

    <div class="mt-5 grid grid-cols-11 gap-x-6 pb-20">
        <div class="intro-y col-span-11 2xl:col-span-9">
            <form class="validate-form">
                @csrf

                <!-- BEGIN: Create Permission Form -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ChevronDown" /> Permission Details
                        </div>

                        <div class="mt-5">
                            <!-- Permission Name Input -->
                            <x-base.form-inline class="mt-5 flex-col items-start pt-5 xl:flex-row" formInline>
                                <x-base.form-label class="xl:!mr-10 xl:w-64" for="perm-name">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Permission Name</div>
                                            <div class="ml-2 rounded-md bg-slate-200 px-2 py-0.5 text-xs text-slate-600 dark:bg-darkmode-300 dark:text-slate-400">
                                                Required
                                            </div>
                                        </div>
                                        <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                            Enter a unique name for the permission (e.g., "view users", "delete surveys").
                                        </div>
                                    </div>
                                </x-base.form-label>

                                <div class="mt-3 w-full flex-1 xl:mt-0">
                                    <div class="input-form">
                                        <x-base.form-input id="perm-name" name="perm-name" type="text" placeholder="Permission name" minlength="5" required />
                                    </div>
                                </div>
                            </x-base.form-inline>
                        </div>
                    </div>
                </div>
                <!-- END: Create Permission Form -->

                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <x-base.button class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52" type="button" href="{{ route('permissions.index') }}" as="a">
                        Cancel
                    </x-base.button>
                    <x-base.button class="w-full py-3 md:w-52" type="submit" variant="primary">
                        Save
                    </x-base.button>
                </div>
            </form>
        </div>
    </div>
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')
    @vite('resources/js/vendors/toastify.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/createPermission.js')
@endPushOnce
```

---

## 📌 **2️⃣ Explanation of Blade Components**
The project utilizes **custom Blade components** stored in:

📂 `resources/views/components/base/`

These components standardize the UI and **make forms reusable** across different parts of the application.

### **🔹 Commonly Used Form Components**
| Component | File Location | Purpose |
|-----------|--------------|---------|
| `x-base.form-inline` | `resources/views/components/base/form-inline.blade.php` | Wraps form fields for consistent layout |
| `x-base.form-label` | `resources/views/components/base/form-label.blade.php` | Displays input labels |
| `x-base.form-input` | `resources/views/components/base/form-input.blade.php` | Standardized input field |
| `x-base.button` | `resources/views/components/base/button.blade.php` | Styled buttons for form submission |
| `x-base.lucide` | `resources/views/components/base/lucide.blade.php` | Icon component for UI elements |

---

## 📌 **3️⃣ Handling Form Submission with Axios**
In `resources/js/pages/createPermission.js`, **Axios** is used to **send the form data asynchronously**.

### **🔹 JavaScript Code**
```js
(function () {
    "use strict";

    $(".validate-form").each(function () {
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        $(this).on("submit", function (e) {
            e.preventDefault();
            let valid = pristine.validate();

            if (valid) {
                let formData = {
                    name: $("input[name='perm-name']").val(),
                };

                axios.post("/permissions", formData)
                    .then(response => {
                        window.location.href = `${window.routes.permissionsIndex}?success=${encodeURIComponent(response.data.message)}`;
                    })
                    .catch(error => {
                        window.location.href = `${window.routes.permissionsIndex}?error=Failed to create permission.`;
                    });
            }
        });
    });
})();
```

---

## 📌 **4️⃣ Processing the Form Request in Laravel**
In `app/Http/Controllers/PermissionController.php`, the form submission is processed.

### **🔹 Controller Method**
```php
public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|min:5|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' created successfully."
        ], 201);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => "Failed to create permission.",
            'error' => $e->getMessage()
        ], 500);
    }
}
```

---

## 📌 **5️⃣ Displaying Toast Notifications**
Success and error messages are displayed using **Toastify.js**.

### **🔹 Notification Blade Snippet**
```blade
<x-base.notification id="success-notification-content" data-message="{{ session('success') }}">
    <x-base.lucide class="text-success" icon="CheckCircle" />
    <div class="ml-4 mr-4">
        <div class="font-medium">Success!</div>
        <div class="mt-1 text-slate-500">{{ session('success') }}</div>
    </div>
</x-base.notification>
```

---

## **🚀 Summary**
✔️ **Use standardized Blade components for consistent UI**  
✔️ **Handle form submission with Axios**  
✔️ **Validate and process data in Laravel controller**  
✔️ **Return JSON responses & display toast notifications**  

💡 **Reminder:** Always refer to `resources/views/components/base/` for Blade component details.

🚀 **Happy coding!** 🚀
