# Survey Management System

## Overview
This project is a **Survey Management System** built using Laravel. It allows users to create, manage, and analyze survey schemas and responses efficiently. The system supports multiple user roles and permissions, ensuring secure access control.

## Features
- **Survey Schema Management**: Create, update, and manage survey schemas.
- **Survey Responses**: Collect and analyze survey responses.
- **Role-Based Access Control (RBAC)**: Uses **Spatie Laravel Permission** to manage roles and permissions.
- **User Authentication & Security**: Implemented using **Laravel Fortify** for secure login, registration, and authentication.
- **SurveyJS Integration**: Provides a seamless experience for designing and displaying surveys.
- **Export Features**: Supports CSV and Excel export for survey results.
- **Pagination & Search**: Easy navigation through survey lists.
- **Dynamic UI**: Interactive UI components powered by TailwindCSS and Vue.js.

## Technologies Used
- **Laravel** - PHP Framework
- **Spatie Laravel Permission** - Role and Permission Management
- **Laravel Fortify** - Authentication and Security
- **SurveyJS** - Survey Builder and Viewer
- **Vue.js** - Frontend Interactivity
- **TailwindCSS** - UI Styling
- **MySQL** - Database Management

## Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/survey-management.git
   cd survey-management
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install
   ```
3. Copy the environment file and set up the database:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure `.env` file with database and mail settings.
5. Run migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```
6. Start the development server:
   ```sh
   php artisan serve
   ```

## Usage
- Log in as an administrator to manage surveys.
- Create, edit, and publish survey schemas.
- Assign roles and permissions using Spatie.
- Analyze survey responses and export reports.

## Contribution
Feel free to submit issues and pull requests to enhance the system.

## License
This project is licensed under the MIT License.
