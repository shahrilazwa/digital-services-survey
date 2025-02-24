# 📊 **Digital Services Survey**

## **Overview**
The **Digital Services Survey System** is a **Government Digital Services Feedback Platform** that enables **public agencies** to **create**, **manage**, and **analyze** surveys related to **digital services** offered by the government.

This system allows agencies to:

- ✔️ **Create & Manage Surveys** – Users can design reusable **survey schemas** to avoid redundant setup.  
- ✔️ **Publish Surveys with a Shareable Link** – A **unique URL** is generated for each published survey. This link can be **shared on external platforms**, websites, or applications.  
- ✔️ **Collect and Analyze Feedback** – Responses can be **structured (database)** or **unstructured (JSON)**.  
- ✔️ **Export Survey Results** – Download responses in **CSV format** for in-depth analysis.  
- ✔️ **Government Service Mapping** – Links surveys to **specific agencies and digital services**.  
- ✔️ **Access Control & Security** – Uses **Spatie Laravel Permission** for **RBAC** (Role-Based Access Control).  
- ✔️ **Form Validation** – Uses **Pristine.js** for **real-time input validation** on forms.

This system is **designed to ensure data consistency**, **survey question reuse**, and **targeted feedback collection** to help improve digital services.

---

## 🚀 **Features**
The **Digital Services Survey System** offers the following features:

### 🔹 **Survey Management**
- **Create & Edit Surveys** – Users can **design survey schemas**, reuse questions, and update existing surveys.  
- **Publish Surveys** – Each survey schema can be **published**, generating a **unique URL** for external sharing.  
- **Survey Expiry & Control** – Surveys can be **set to expire** or **restricted to specific users**.  

### 🔹 **Survey Responses & Analytics**
- **Capture Detailed Feedback** – Collect **structured & unstructured** data for analysis.  
- **Export Survey Data** – Download responses in **CSV format**.  
- **View Survey Analytics** – Analyze trends and user feedback over time.  

### 🔹 **Security & Access Control**
- **User Roles & Permissions** – Uses **Spatie Laravel Permission** for **RBAC** (Role-Based Access Control).  
- **Secure Authentication** – Uses **Laravel Fortify** to ensure **secure user login** and **session management**.  

### 🔹 **Dynamic UI & Notifications**
- **Toast Notifications** – Provides **real-time alerts** (success, info, and errors).  
- **Activity Logging** – Tracks changes and **displays notifications** for recent activities.  
- **Modern UI Framework** – Built with **Vue.js**, **TailwindCSS**, and **SurveyJS**.  
- **Real-Time Form Validation** – Uses **Pristine.js** for **frontend form validation**.

---

## 🖥️ **Screenshots**

### 📌 **Admin Panel Dashboard**
![Admin Panel](docs/screenshots/admin-dashboard.png)

### 📌 **Survey Creation Interface**
![Survey Schema](docs/screenshots/survey-schema.png)

### 📌 **Published Survey & Response Collection**
![Published Survey](docs/screenshots/published-survey.png)

💡 **Reminder:** You can update screenshots by replacing the images inside `docs/screenshots/`.

---

## 🛠 **Technologies Used**

| **Technology**  | **Purpose** |
|----------------|------------|
| **Laravel** | Backend framework (PHP) |
| **Spatie Laravel Permission** | Role-Based Access Control (RBAC) |
| **Laravel Fortify** | Secure authentication |
| **SurveyJS** | Survey builder & response collection |
| **Vue.js** | Frontend interactivity |
| **TailwindCSS** | Modern UI styling |
| **MySQL** | Database storage |
| **Axios** | API communication between frontend & backend |
| **Toastify.js** | Interactive toast notifications |
| **Pristine.js** | Real-time form validation |
| **Vite** | Frontend asset bundling & development |

💡 **Reminder:** Axios and Pristine.js are used in the project for **handling HTTP requests** and **form validation**, respectively. Ensure they are included in your Blade templates:

```blade
@pushOnce('vendors')
    @vite('resources/js/vendors/axios.js')
    @vite('resources/js/vendors/toastify.js')
    @vite('resources/js/vendors/pristine.js')
@endPushOnce
```

---

## 📥 **Installation Guide**

1️⃣ **Clone the Repository:**
```sh
git clone https://github.com/shahrilazwa/digital-services-survey.git
cd digital-services-survey
```

2️⃣ **Install Dependencies:**
```sh
composer install
npm install
```

3️⃣ **Set Up Environment Variables:**
```sh
cp .env.example .env
php artisan key:generate
```
- Open the `.env` file and configure:
  - **Database connection** (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
  - **Mail settings** for email notifications

4️⃣ **Run Migrations & Seeders:**
```sh
php artisan migrate --seed
```
- This will create the database schema and insert default roles & permissions.

5️⃣ **Start the Development Server:**
```sh
php artisan serve
```

6️⃣ **Compile Frontend Assets (Vite)**
```sh
npm run dev
```
- This ensures that frontend styles, scripts, and Vue components **are built correctly**.
- If running in **production**, use:
```sh
npm run build
```

💡 **Reminder:** Vite must be running for UI updates to reflect automatically in development mode.

---

## 📌 **Usage Guide**

🔹 **Admin Panel**  
- Log in as an **admin** to access the dashboard.  
- Manage **surveys, users, and permissions**.  
- Assign **roles** to control user access.  

🔹 **Creating & Publishing Surveys**  
- Navigate to **Survey Management**.  
- **Create a new survey schema** or select an existing template.  
- **Publish the survey** – A **unique link** will be generated.  
- Share this **link on external platforms** (government portals, applications, emails).  

🔹 **Collecting Survey Responses**  
- Users can **access the survey via the published link**.  
- Responses are **stored in the database** and **available for download**.  
- Data can be **filtered and exported** in **CSV format**.  

🔹 **Notifications & Activity Tracking**  
- Users receive **real-time toast notifications** when actions are performed.  
- Activity logs display **recent updates, changes, and errors**.  

🔹 **Form Validation with Pristine.js**  
- Forms are validated **before submission**.  
- Input fields show **real-time validation errors** if values are missing or invalid.  
- Ensures **data integrity** before reaching the backend.  

---

## 📑 **Standard Documentation**

This project follows **strict coding and documentation standards**. Below are some of the included guides:

| 📄 **Document** | 📜 **Description** |
|----------------|------------------|
| `docs/toast-notifications.md` | Standard implementation for **toast notifications** (success, error, info). |
| `docs/activity-notifications.md` | How to display **user activity notifications**. |
| `docs/access-control.md` | **Role-based access control (RBAC)** using **Spatie Laravel Permission**. |
| `docs/survey-management.md` | Guidelines for **creating, managing, and publishing surveys**. |

💡 **Reminder:** Always refer to these documents when making changes or enhancements.

---

## 🤝 **Contribution Guidelines**
We **welcome contributions**! If you’d like to **improve features**, **fix bugs**, or **add documentation**, follow these steps:

1. **Fork the repository**.
2. **Create a new feature branch** (`git checkout -b feature-branch-name`).
3. **Commit your changes** (`git commit -m "Describe your changes"`).
4. **Push to your branch** (`git push origin feature-branch-name`).
5. **Submit a pull request (PR)**.

---

## 📝 **License**
This project is **MIT Licensed**.  
Feel free to use, modify, and distribute it **with proper attribution**.  

📌 **GitHub Repository:** [Digital Services Survey](https://github.com/shahrilazwa/digital-services-survey)  

🚀 **Built with Laravel, Vue.js, and SurveyJS for a better digital survey experience!**
