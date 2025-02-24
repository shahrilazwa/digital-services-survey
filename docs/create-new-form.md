# 📜 **Guide to Creating a New Form**

## **Overview**
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

| **Component** | **Purpose** |
|--------------|-------------|
| `x-base.form-inline` | Wraps a group of related form fields in a **row layout**. |
| `x-base.form-label` | Displays **label text** for form inputs. |
| `x-base.form-input` | Renders a **standard text input** field. |
| `x-base.form-textarea` | Provides a **multi-line text input (textarea)**. |
| `x-base.form-select` | Creates a **dropdown selection menu**. |
| `x-base.form-checkbox` | Generates **checkbox inputs**. |
| `x-base.form-radio` | Creates **radio button inputs**. |
| `x-base.button` | Renders **buttons for actions (Submit, Cancel, etc.)**. |

---

### **📌 Understanding Each Component in Detail**

#### **🔹 1. `x-base.form-inline`**
Wraps related form elements together in a **consistent row layout**.

```blade
<x-base.form-inline>
    <x-base.form-label for="perm-name">Permission Name</x-base.form-label>
    <x-base.form-input name="perm-name" type="text" required />
</x-base.form-inline>
```

---

#### **🔹 2. `x-base.form-label`**
Displays **form labels** consistently.

```blade
<x-base.form-label for="perm-name">
    Permission Name
</x-base.form-label>
```

---

#### **🔹 3. `x-base.form-input`**
Creates a **text input field**.

```blade
<x-base.form-input name="perm-name" type="text" placeholder="Enter permission name" required />
```

---

#### **🔹 4. `x-base.form-select`**
Creates a **dropdown selection** field.

```blade
<x-base.form-select name="role" :options="$roles" required />
```

---

#### **🔹 5. `x-base.form-checkbox`**
Creates a **checkbox input**.

```blade
<x-base.form-checkbox name="terms" label="Accept Terms" required />
```

---

#### **🔹 6. `x-base.button`**
Creates **buttons for actions**.

```blade
<x-base.button type="submit" variant="primary">
    Save
</x-base.button>
```

---

🚀 **By following this approach, we ensure robust, secure, and user-friendly forms across the Digital Services Survey System!** 🚀
