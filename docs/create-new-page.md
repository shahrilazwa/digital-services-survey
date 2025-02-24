# 📜 **Creating a New Page**

## **Introduction**
The **Digital Services Survey System** follows a structured approach when adding new pages to ensure **code maintainability**, **consistency**, and **modular development**.

This guide will walk you through the **step-by-step process** of creating a **new page**, including:

✔️ **Adding a New Menu Item** – So that users can navigate to the new page.  
✔️ **Defining Routes** – So Laravel knows how to access the new page.  
✔️ **Creating a Blade Template** – To display content using Laravel’s templating system.  
✔️ **Using the Header & Footer Components** – Ensuring a consistent design across all pages.  
✔️ **Adding JavaScript and External Dependencies** – Enabling dynamic features for interactivity.  

By the end of this guide, you will have a **fully functional new page** in your Laravel project.

---

## 📌 **1️⃣ Adding a New Menu Item**
### **What is the Sidebar Menu?**
The sidebar menu allows users to navigate through different sections of the application. Each **menu item** corresponds to a specific **page** or **functionality**.

### **How to Add a New Menu Item**
1. **Locate the sidebar menu file**  
   - Open `app\Main\SideMenu.php`
   - This file **defines all the menu items** displayed in the sidebar.

2. **Add a new menu entry**  
   - Find the section where similar pages are listed.
   - Add a new array entry for your page.

📌 **Example: Adding a "Survey Schemas" Menu**
```php
$menu[] = [
    'icon' => 'List', // Use a relevant Lucide icon
    'title' => 'Survey Schemas', // The menu label
    'route_name' => 'schemas.index', // The Laravel route that points to this page
    'permission' => 'view schemas', // Ensures only authorized users can access
];
```
### **Understanding the Code:**
- **`icon`** → Defines the menu icon (uses Lucide icons).  
- **`title`** → The label shown in the sidebar.  
- **`route_name`** → The Laravel route that loads the page.  
- **`permission`** → Ensures **only authorized users** can see the menu item.

💡 **Reminder:** If you don’t add a corresponding **route**, clicking the menu **will result in an error**.

---

## 📌 **2️⃣ Defining the Route**
### **What is a Route in Laravel?**
Routes define **how users access pages** in a Laravel application. When a user visits a URL (e.g., `/schemas`), Laravel looks for a **matching route** to determine **which controller** and **function** should handle the request.

### **Steps to Create a New Route File**
1. **Go to the `routes/` folder** in your Laravel project.
2. **Create a new route file**, e.g., `routes/schema_routes.php`.
3. **Define your routes** inside this file.

📌 **Example: Defining Routes for Survey Schemas**
```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveySchemaController;

// Routes for managing survey schemas
Route::middleware(['auth'])->group(function () {
    Route::get('/schemas', [SurveySchemaController::class, 'index'])->name('schemas.index');
    Route::get('/schemas/create', [SurveySchemaController::class, 'create'])->name('schemas.create');
    Route::post('/schemas', [SurveySchemaController::class, 'store'])->name('schemas.store');
});
```
### **Explanation of the Code:**
- **`Route::middleware(['auth'])`** → Ensures only **logged-in users** can access these routes.
- **`Route::get('/schemas', [SurveySchemaController::class, 'index'])`** → Loads the **index** page.
- **`Route::get('/schemas/create', [SurveySchemaController::class, 'create'])`** → Loads the **create new survey page**.
- **`Route::post('/schemas', [SurveySchemaController::class, 'store'])`** → Handles form submissions.

💡 **Reminder:** Routes **must be registered** for Laravel to recognize them.

---

## 📌 **3️⃣ Registering the Route in `web.php`**
### **Why Do We Need to Register the Route?**
Laravel does **not** automatically load custom route files. We must **manually include them** inside `routes/web.php` to make sure they are recognized.

### **Steps to Register the Route File**
1. **Open `routes/web.php`**
2. **Scroll to the bottom of the file**
3. **Add the following line:**
```php
require base_path('routes/schema_routes.php');
```
### **Explanation:**
- `require base_path('routes/schema_routes.php');` → This tells Laravel to **load the routes inside `schema_routes.php`**.

💡 **Reminder:** Without this step, **visiting the new page will return a "404 Not Found" error**.

---

## 📌 **4️⃣ Creating a Blade Template**
### **What is a Blade Template?**
Blade is Laravel’s **templating engine**, allowing us to **reuse components** and **structure our views efficiently**.

### **Steps to Create a Blade View**
1. **Navigate to:** `resources/views/auth/admin/schemas/`
2. **Create a new file:** `index.blade.php`
3. **Copy the template structure below:**

📌 **Example: `resources/views/auth/admin/schemas/index.blade.php`**
```blade
@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Survey Schemas</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Survey Schemas</h2>
    <!-- Add your page content here -->
@endsection

@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')
    @vite('resources/js/vendors/toastify.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/pages/listSchemas.js')
@endPushOnce
```
### **Understanding the Structure**
- **`@extends('../themes/' . $activeTheme . '/' . $activeLayout)`** → Uses the **base layout**.
- **`@section('subhead')`** → Defines the **title of the page**.
- **`@section('subcontent')`** → The **main content area**.
- **`@pushOnce('vendors')`** → Loads **Axios and Toastify.js**.
- **`@pushOnce('scripts')`** → Loads **page-specific JavaScript**.

💡 **Reminder:** This structure ensures **UI consistency across all pages**.

---

## 📌 **5️⃣ Adding JavaScript Support**
### **Why Use JavaScript?**
JavaScript enhances interactivity, such as:
✔️ **Form validation**  
✔️ **Dynamic content updates**  
✔️ **Displaying toast notifications**  

### **Steps to Add JavaScript**
1. **Navigate to `resources/js/pages/`**
2. **Create a new file**, e.g., `listSchemas.js`
3. **Add basic JavaScript code:**

📌 **Example: `resources/js/pages/listSchemas.js`**
```js
(function () {
    "use strict";

    console.log("Survey Schemas Page Loaded");

    // Example Toast Notification
    Toastify({
        text: "Welcome to Survey Schemas",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
    }).showToast();
})();
```
💡 **Reminder:** Make sure `listSchemas.js` is **linked inside the Blade file** under `@pushOnce('scripts')`.

---

## 🔹 **Final Checklist**
✔️ **Added a Menu Item** (`app\Main\SideMenu.php`)  
✔️ **Created a Route File** (`routes/schema_routes.php`)  
✔️ **Registered the Route** in `routes/web.php`  
✔️ **Created a Blade View** (`resources/views/auth/admin/schemas/index.blade.php`)  
✔️ **Used Header & Footer Components** (`top-bar/index.blade.php`, `footer/index.blade.php`)  
✔️ **Added JavaScript Support** (`resources/js/pages/listSchemas.js`)  

🚀 **Your new page is now fully functional!** 🚀
