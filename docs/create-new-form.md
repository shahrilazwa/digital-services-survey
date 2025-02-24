## 📜 **Guide to Creating a New Form**

### **Overview**
Forms are an essential part of any web application, allowing users to **submit data**, such as **creating users, permissions, surveys, or responses**.  
The **Digital Services Survey System** enforces **structured form creation**, ensuring **consistent UI, validation, and interactivity** using:

✔️ **Reusable Blade Components** – Enforces uniformity across the UI.  
✔️ **Pristine.js for Frontend Validation** – Ensures form inputs meet defined requirements.  
✔️ **Axios for Form Submission** – Handles asynchronous form requests to the backend.  
✔️ **Laravel for Server-Side Validation** – Secures data integrity at the application level.  
✔️ **Toastify.js for Notifications** – Displays user feedback after form submission.  

---

## 📌 **1️⃣ Setting Up the Blade File for the Form**
Each form must **follow the standard templating structure** for **maintainability and usability**.

### **🔹 File Location for New Forms**
The form should be stored under:

📂 `resources/views/auth/admin/[entity]/create.blade.php`

For example, to **create a new permission**, the file should be:

📂 `resources/views/auth/admin/permissions/create.blade.php`

### **🔹 Standard Form Blade Template**
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
    @vite('resources/js/vendors/pristine.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/createPermission.js')
@endPushOnce
```

---

## 📌 **2️⃣ Understanding Blade Form Components**
The **Digital Services Survey System** follows a **component-based approach** for UI standardization and code reusability.  
Blade components are used to ensure that **forms have a uniform structure** across the entire system.

📂 **Component Directory:** `resources/views/components/base/`

Each **form input element** is wrapped inside **Blade components** to simplify **code structure and maintenance**.  
This approach improves **readability, reusability, and design consistency** across the application.

### **🔹 Benefits of Using Blade Components**
✔️ **Reusability** – Avoids repetitive HTML code across forms.  
✔️ **Consistency** – Ensures all forms follow a **standardized layout**.  
✔️ **Maintainability** – Makes UI updates easier by modifying a single component instead of updating multiple files.  

---

### **📌 Commonly Used Form Components**

Below is a list of **frequently used Blade form components**, including their **file locations**, **purposes**, and **usage examples**.

| **Component** | **File Location** | **Purpose** | **Example Usage** |
|--------------|-------------------|-------------|--------------------|
| `x-base.form-inline` | `resources/views/components/base/form-inline.blade.php` | Wraps a group of related form fields in a **row layout**. | `<x-base.form-inline class="xl:flex-row" formInline> ... </x-base.form-inline>` |
| `x-base.form-label` | `resources/views/components/base/form-label.blade.php` | Displays **label text** for form inputs. | `<x-base.form-label for="perm-name"> Permission Name </x-base.form-label>` |
| `x-base.form-input` | `resources/views/components/base/form-input.blade.php` | Renders a **standard text input** field. | `<x-base.form-input name="perm-name" type="text" required />` |
| `x-base.form-textarea` | `resources/views/components/base/form-textarea.blade.php` | Provides a **multi-line text input (textarea)**. | `<x-base.form-textarea name="description" placeholder="Enter description..." required />` |
| `x-base.form-select` | `resources/views/components/base/form-select.blade.php` | Creates a **dropdown selection menu**. | `<x-base.form-select name="role" :options="$roles" required />` |
| `x-base.form-checkbox` | `resources/views/components/base/form-checkbox.blade.php` | Generates **checkbox inputs**. | `<x-base.form-checkbox name="terms" label="Accept Terms" required />` |
| `x-base.form-radio` | `resources/views/components/base/form-radio.blade.php` | Creates **radio button inputs**. | `<x-base.form-radio name="gender" :options="['Male', 'Female']" required />` |
| `x-base.button` | `resources/views/components/base/button.blade.php` | Renders **buttons for actions (Submit, Cancel, etc.)**. | `<x-base.button type="submit" variant="primary"> Save </x-base.button>` |

---

### **📌 Understanding Each Component in Detail**

Below is a **detailed explanation** of each component along with an example.

#### **🔹 1. `x-base.form-inline`**
This **wraps related form elements** together to **maintain alignment** in a row.

📂 **File Location:** `resources/views/components/base/form-inline.blade.php`
```blade
<x-base.form-inline class="mt-5 flex-col items-start pt-5 xl:flex-row" formInline>
    <x-base.form-label class="xl:!mr-10 xl:w-64" for="perm-name">
        Permission Name
    </x-base.form-label>

    <div class="mt-3 w-full flex-1 xl:mt-0">
        <x-base.form-input id="perm-name" name="perm-name" type="text" required />
    </div>
</x-base.form-inline>
```
📌 **Purpose:** Ensures a **consistent row layout** for form fields.

---

#### **🔹 2. `x-base.form-label`**
Defines the **label for an input field**.

📂 **File Location:** `resources/views/components/base/form-label.blade.php`
```blade
<x-base.form-label for="perm-name">
    Permission Name
</x-base.form-label>
```
📌 **Purpose:** Ensures all **form labels are uniform** across different pages.

---

#### **🔹 3. `x-base.form-input`**
Creates a **text input field**.

📂 **File Location:** `resources/views/components/base/form-input.blade.php`
```blade
<x-base.form-input name="perm-name" type="text" placeholder="Enter permission name" required />
```
📌 **Purpose:** Provides a **reusable text input** field.

---

#### **🔹 4. `x-base.form-textarea`**
Creates a **multi-line text field (textarea)**.

📂 **File Location:** `resources/views/components/base/form-textarea.blade.php`
```blade
<x-base.form-textarea name="description" placeholder="Enter description..." required />
```
📌 **Purpose:** Used for **longer text inputs**.

---

#### **🔹 5. `x-base.form-select`**
Creates a **dropdown selection** field.

📂 **File Location:** `resources/views/components/base/form-select.blade.php`
```blade
<x-base.form-select name="role" :options="$roles" required />
```
📌 **Purpose:** Provides **dynamic dropdown menus**.

---

#### **🔹 6. `x-base.form-checkbox`**
Creates a **checkbox input**.

📂 **File Location:** `resources/views/components/base/form-checkbox.blade.php`
```blade
<x-base.form-checkbox name="terms" label="Accept Terms" required />
```
📌 **Purpose:** Allows **users to select multiple options**.

---

#### **🔹 7. `x-base.form-radio`**
Creates **radio button inputs**.

📂 **File Location:** `resources/views/components/base/form-radio.blade.php`
```blade
<x-base.form-radio name="gender" :options="['Male', 'Female']" required />
```
📌 **Purpose:** Provides **single-choice selection**.

---

#### **🔹 8. `x-base.button`**
Creates **buttons for actions**.

📂 **File Location:** `resources/views/components/base/button.blade.php`
```blade
<x-base.button type="submit" variant="primary">
    Save
</x-base.button>
```
📌 **Purpose:** Used for **submitting forms or navigating**.

---

## **📌 Why Use Blade Components?**
1️⃣ **Consistency:** All forms look and behave the same way.  
2️⃣ **Maintainability:** Updating a component automatically updates all forms using it.  
3️⃣ **Code Reusability:** Avoids duplicate code across different views.  
4️⃣ **Easier Debugging:** Debugging components is **simpler and more centralized**.  

---

---

## 📌 **3️⃣ Implementing Server-Side Validation in Laravel**
```php
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|min:5|unique:permissions,name',
    ]);

    try {
        $permission = Permission::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' created successfully."
        ], 201);
    } catch (Exception $e) {
        Log::error("Permission creation failed: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => "Failed to create permission.",
        ], 500);
    }
}
```
## 📌 **4️⃣ Implementing Client-Side Validation Using Pristine.js**
In addition to **server-side validation**, **client-side validation** ensures that **incorrect data is prevented before submission**, reducing unnecessary API calls.

### **🔹 What is Pristine.js?**
[Pristine.js](https://github.com/sha256/Pristine) is a **lightweight form validation library** that helps:
- Validate form inputs **before submission**.
- **Prevent form submission** until all fields meet the required criteria.
- Display **custom error messages** dynamically.

---

### **🔹 Installing Pristine.js**
Ensure **Pristine.js** is included in your **Blade template**:

📂 `resources/views/auth/admin/permissions/create.blade.php`
```blade
@pushOnce('vendors')
    @vite('resources/js/vendors/pristine.js')
@endPushOnce
```

---

### **🔹 Adding Validation Rules**
Each input field should follow **HTML validation attributes** like:
```blade
<x-base.form-input id="perm-name" name="perm-name" type="text" placeholder="Permission name" minlength="5" required />
```
- `required` → Ensures the field is **not empty**.
- `minlength="5"` → Enforces **minimum character length**.

---

### **🔹 JavaScript Code for Form Validation**
📂 `resources/js/pages/createPermission.js`
```js
(function () {
    "use strict";

    // Select the form
    $(".validate-form").each(function () {
        // Initialize Pristine.js
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        // Form submission event
        $(this).on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            // Validate form
            let valid = pristine.validate();
            if (!valid) {
                console.warn("Form validation failed!");
                return;
            }

            // Collect form data
            let formData = {
                name: $("input[name='perm-name']").val(),
            };

            // Submit data via Axios
            axios.post("/permissions", formData)
                .then(response => {
                    window.location.href = `${window.routes.permissionsIndex}?success=${encodeURIComponent(response.data.message)}`;
                })
                .catch(error => {
                    window.location.href = `${window.routes.permissionsIndex}?error=Failed to create permission.`;
                });
        });
    });
})();
```

---

### **🔹 How Validation Works**
1. When the user **clicks submit**, **Pristine.js** checks all form fields.
2. If **any field is invalid**, the form **does not submit**, and **error messages** are displayed.
3. If all fields are valid, **Axios sends the form data** to the server.
4. If the **server validation fails**, an error message is displayed.

---

### **🔹 Displaying Error Messages**
Pristine.js **automatically inserts error messages** near invalid fields.

Example: If a user **leaves the field empty**, they will see:
```plaintext
⚠️ Permission name is required.
```

Example: If a user enters **less than 5 characters**, they will see:
```plaintext
⚠️ The permission name must be at least 5 characters.
```

---

You're right! Below is the **fully expanded and improved** **"5️⃣ Combining Client-Side & Server-Side Validation"** section, ensuring it is **detailed, structured, and easy to understand** for developers of all levels.

---

## 📌 **5️⃣ Combining Client-Side & Server-Side Validation**
Validation is crucial for ensuring **data integrity, security, and a seamless user experience**.  
In the **Digital Services Survey System**, both **client-side and server-side validation** are used **together** to provide a **robust validation mechanism**.

By combining **Pristine.js (client-side validation)** and **Laravel (server-side validation)**, we achieve the following:

✔️ **Prevent invalid form submissions on the frontend** (reducing unnecessary server requests).  
✔️ **Ensure security at the backend** by verifying all incoming data before processing it.  
✔️ **Improve user experience** by displaying **instant error messages** without needing a page refresh.  
✔️ **Standardize validation rules** across the application.  

---

### **🔹 How Client-Side & Server-Side Validation Work Together**
| **Step** | **Validation Type** | **Purpose** | **Example Implementation** |
|----------|----------------|-----------------------------|--------------------|
| **1️⃣ Client-Side Validation (Pristine.js)** | Prevents invalid data **before submission** | Ensures users fill out required fields before sending data to the server. | Pristine.js |
| **2️⃣ Server-Side Validation (Laravel)** | Ensures data integrity **at the backend** | Protects against tampered or missing data. | Laravel Controller |
| **3️⃣ JSON Response Handling (Axios)** | Displays success/error messages dynamically | Shows real-time feedback after submission. | Toastify.js |

---

## 📌 **A. Implementing Client-Side Validation with Pristine.js**
### **What is Pristine.js?**
[Pristine.js](https://github.com/sha256/Pristine) is a **lightweight JavaScript form validation library** that:
- **Validates form inputs before submission** (avoiding unnecessary server calls).
- **Prevents submission of empty or incorrectly formatted fields**.
- **Displays real-time error messages near invalid fields**.

### **How It Works in This Project**
1. The form is initialized with **Pristine.js**.
2. **When the user submits the form, Pristine.js checks for errors**.
3. If any field **fails validation**, an **error message** is displayed near the field.
4. The form **is not submitted until all errors are resolved**.

---

### **🔹 Example Pristine.js Code**
📂 **File:** `resources/js/pages/createPermission.js`
```js
(function () {
    "use strict";

    // Select the form
    $(".validate-form").each(function () {
        // Initialize Pristine.js
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        // Form submission event
        $(this).on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            // Validate form
            let valid = pristine.validate();
            if (!valid) {
                console.warn("Form validation failed!");
                return;
            }

            // Collect form data
            let formData = {
                name: $("input[name='perm-name']").val(),
            };

            // Submit data via Axios
            axios.post("/permissions", formData)
                .then(response => {
                    window.location.href = `${window.routes.permissionsIndex}?success=${encodeURIComponent(response.data.message)}`;
                })
                .catch(error => {
                    window.location.href = `${window.routes.permissionsIndex}?error=Failed to create permission.`;
                });
        });
    });
})();
```

### **🔹 How This Works**
✔️ **Prevents the form from submitting unless all required fields are valid**.  
✔️ **Displays error messages dynamically if the user enters incorrect data**.  
✔️ **If valid, data is sent to the backend via Axios** for processing.  

---

## 📌 **B. Implementing Server-Side Validation in Laravel**
Even though **Pristine.js handles client-side validation**, **server-side validation is still required** because:
- **Users can bypass frontend validation (e.g., by disabling JavaScript)**.
- **Server validation protects against malicious inputs**.
- **Ensures business logic is correctly enforced**.

### **🔹 Example Laravel Validation in Controller**
📂 **File:** `app/Http/Controllers/PermissionController.php`
```php
public function store(Request $request)
{
    // Validate incoming data
    $validatedData = $request->validate([
        'name' => 'required|string|min:5|unique:permissions,name',
    ]);

    try {
        // Save permission to database
        $permission = Permission::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' created successfully."
        ], 201);
    } catch (Exception $e) {
        // Log error for debugging
        Log::error("Permission creation failed: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => "Failed to create permission.",
        ], 500);
    }
}
```

### **🔹 How This Works**
✔️ **Validates incoming request data using Laravel’s `validate()` method**.  
✔️ **If validation fails, Laravel automatically returns an error response**.  
✔️ **If validation passes, the permission is saved in the database**.  
✔️ **Errors are logged in case debugging is needed**.

---

## 📌 **C. Handling JSON Response & Displaying Notifications**
Once the request is processed **(either successfully or with an error)**, the response needs to be displayed to the user.

### **🔹 Example JSON Response**
✅ **Success Response**
```json
{
    "success": true,
    "message": "Permission 'Manage Users' created successfully."
}
```
❌ **Error Response**
```json
{
    "success": false,
    "message": "Failed to create permission."
}
```

---

## 📌 **D. Displaying Toast Notifications**
To notify the user of the **submission result**, we use **Toastify.js**.

📂 **File:** `resources/views/auth/admin/permissions/index.blade.php`
```blade
<x-base.notification id="success-notification-content" data-message="{{ session('success') }}">
    <x-base.lucide class="text-success" icon="CheckCircle" />
    <div class="ml-4 mr-4">
        <div class="font-medium">Success!</div>
        <div class="mt-1 text-slate-500">{{ session('success') }}</div>
    </div>
</x-base.notification>
```

📌 **How It Works**:
✔️ **Success messages are displayed in a green toast notification**.  
✔️ **Error messages appear in a red notification**.  
✔️ **Notifications disappear automatically after a few seconds**.  

---

## 📌 **E. Summary: How the Validation Works Together**
1️⃣ **Client-Side Validation (Pristine.js)**  
   - Prevents empty or invalid data from being submitted.  
   - Displays error messages in real-time.  

2️⃣ **Server-Side Validation (Laravel)**  
   - Ensures that submitted data is correct and not tampered with.  
   - Protects against users bypassing frontend validation.  

3️⃣ **Handling JSON Responses & Notifications**  
   - **Axios processes the response** and **Toastify.js displays success/error messages**.  

---

### **🔹 Final Workflow**
1️⃣ **User fills out the form**.  
2️⃣ **Pristine.js validates the input** before submission.  
3️⃣ If valid, **Axios sends the data to Laravel**.  
4️⃣ **Laravel validates the data again on the backend**.  
5️⃣ If successful, **data is stored in the database and a JSON response is sent**.  
6️⃣ **Toastify.js displays a notification** to inform the user.  

---

## 📌 **🚀 Key Takeaways**
✔️ **Always combine frontend and backend validation** for security and a better user experience.  
✔️ **Use Pristine.js to catch errors before sending data to the server**.  
✔️ **Use Laravel validation to ensure proper data integrity at the backend**.  
✔️ **Show real-time error/success messages using Toastify.js**.  

---

🚀 **By following this approach, we ensure robust, secure, and user-friendly forms across the Digital Services Survey System!** 🚀

