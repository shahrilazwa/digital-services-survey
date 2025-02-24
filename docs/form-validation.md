# 📜 **Validation Guide**

## **Overview**
Validation is a critical part of any web application to ensure **data integrity, security, and a seamless user experience**.  
The **Digital Services Survey System** implements **both client-side and server-side validation** using:

✔️ **Pristine.js for Client-Side Validation** – Ensures invalid data is caught before submission.  
✔️ **Laravel for Server-Side Validation** – Provides an additional security layer for data integrity.  
✔️ **Axios for JSON Response Handling** – Manages real-time form submission results.  
✔️ **Toastify.js for Notifications** – Displays success/error messages dynamically.  

This document covers **how validation is implemented**, from **frontend validation with Pristine.js** to **backend validation in Laravel**.

---

## 📌 **1️⃣ Implementing Client-Side Validation with Pristine.js**
Client-side validation **helps prevent invalid data** from being sent to the server.  
This **reduces unnecessary API calls** and **improves user experience** by providing **instant feedback**.

### **🔹 What is Pristine.js?**
[Pristine.js](https://github.com/sha256/Pristine) is a **lightweight JavaScript form validation library** that:
- **Validates form inputs before submission** (avoiding unnecessary server calls).
- **Prevents submission of empty or incorrectly formatted fields**.
- **Displays real-time error messages near invalid fields**.

---

### **🔹 Installing Pristine.js**
Ensure **Pristine.js** is included in your **Blade template**:

📂 **File:** `resources/views/auth/admin/permissions/create.blade.php`
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
✔️ `required` → Ensures the field is **not empty**.  
✔️ `minlength="5"` → Enforces **minimum character length**.

---

### **🔹 JavaScript Code for Form Validation**
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

---

### **🔹 How Client-Side Validation Works**
1️⃣ When the user **clicks submit**, **Pristine.js** checks all form fields.  
2️⃣ If **any field is invalid**, the form **does not submit**, and **error messages** are displayed.  
3️⃣ If all fields are valid, **Axios sends the form data** to the server.  
4️⃣ If the **server validation fails**, an error message is displayed.

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

## 📌 **2️⃣ Implementing Server-Side Validation in Laravel**
Even though **Pristine.js handles client-side validation**, **server-side validation is still required** because:
✔️ **Users can bypass frontend validation (e.g., by disabling JavaScript).**  
✔️ **Server validation protects against malicious inputs.**  
✔️ **Ensures business logic is correctly enforced.**  

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

✔️ **Validates incoming request data using Laravel’s `validate()` method.**  
✔️ **If validation fails, Laravel automatically returns an error response.**  
✔️ **If validation passes, the permission is saved in the database.**  
✔️ **Errors are logged in case debugging is needed.**  

---

## 📌 **3️⃣ Handling JSON Response & Displaying Notifications**
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

## 📌 **4️⃣ Displaying Toast Notifications**
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

✔️ **Success messages appear in green notifications.**  
✔️ **Error messages appear in red notifications.**  
✔️ **Notifications disappear automatically after a few seconds.**  

---

## 📌 **5️⃣ Combining Client-Side & Server-Side Validation**
By combining **Pristine.js (client-side validation)** and **Laravel (server-side validation)**, we achieve:

✔️ **Prevents invalid form submissions on the frontend** (reducing unnecessary server requests).  
✔️ **Ensures security at the backend** by verifying all incoming data before processing it.  
✔️ **Displays instant error messages** without requiring a page refresh.  
✔️ **Standardizes validation rules across the application**.  

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
✔️ **Use Pristine.js to catch errors before sending data to the server.**  
✔️ **Use Laravel validation to ensure proper data integrity at the backend.**  
✔️ **Show real-time error/success messages using Toastify.js.**  

---

🚀 **By following this validation strategy, the Digital Services Survey System ensures a robust, secure, and user-friendly form submission process!** 🚀
