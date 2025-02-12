# Survey Management System

## 📌 Project Overview
This project is a **Survey Management System** built with **Laravel** and **SurveyJS**. It enables users to create, publish, and analyze surveys efficiently. The system supports dynamic schema design, team collaboration, and result visualization with **SurveyJS Table View** and **Tabulator.js**.

## 🎯 Key Features
- **Survey Creation & Schema Management**: Design surveys with customizable templates and schema definitions.
- **Publishing & Execution**: Publish surveys and track execution progress.
- **Survey Results & Analytics**: View responses in a tabular format with export options (CSV & Excel).
- **User Roles & Permissions**: Role-based access control for creating, editing, and managing surveys.
- **Survey Lifecycle Management**: Manage surveys from draft to archive.
- **Dynamic Data Visualization**: Display survey results using **Tabulator.js** with pagination and export features.

## 🏗️ Tech Stack
- **Backend**: Laravel 10 (PHP Framework)
- **Frontend**: Vue.js, TailwindCSS
- **Database**: MySQL
- **Survey Engine**: SurveyJS
- **Data Table**: Tabulator.js
- **Authentication**: Laravel Breeze (JWT-based authentication)

## 📂 Project Structure
```
├── app/                 # Laravel Application Code
│   ├── Models/          # Eloquent Models
│   ├── Controllers/     # Application Controllers
│   ├── Http/           
│   ├── Policies/        # Authorization Policies
├── resources/
│   ├── views/           # Blade Templates (Frontend)
│   ├── js/              # Vue Components
│   ├── css/             # Styling (TailwindCSS)
├── database/            # Migrations & Seeders
├── routes/              # API & Web Routes
├── public/              # Public Assets
├── .env                 # Environment Configuration
└── README.md            # Project Documentation
```

## 🚀 Installation Guide

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/your-repo/survey-management-system.git
cd survey-management-system
```

### 2️⃣ Install Dependencies
```sh
composer install
npm install
```

### 3️⃣ Setup Environment
```sh
cp .env.example .env
php artisan key:generate
```
Configure **database credentials** in `.env` file.

### 4️⃣ Run Migrations & Seed Database
```sh
php artisan migrate --seed
```

### 5️⃣ Start Development Server
```sh
php artisan serve
npm run dev
```

## 🔑 Authentication
- **Login**: `/login`
- **Register**: `/register`
- **Survey Creator**: Requires authentication to access survey creation features.

## 📊 Managing Surveys
- Create new surveys in the **Survey Schema Designer**.
- Assign roles (Admin, Creator, Reviewer) for collaboration.
- Publish surveys and collect responses.
- View survey results in a **Tabulator.js-powered** table.

## 📜 License
This project is licensed under the **MIT License**.

## 🤝 Contribution Guide
Contributions are welcome! Follow these steps:
1. Fork the repository
2. Create a new branch: `git checkout -b feature-name`
3. Commit changes: `git commit -m "Add new feature"`
4. Push to the branch: `git push origin feature-name`
5. Open a Pull Request
