# Digital Services Survey

## Overview
The **Digital Services Survey** is a government feedback platform that enables public agencies to create, manage, and analyze surveys related to digital services. This system streamlines data collection, analysis, and reporting for enhanced decision-making.

### Key Features
- ✅ **Survey Management**: Create, edit, and publish surveys
- ✅ **Survey Responses & Analytics**: Collect structured & unstructured feedback
- ✅ **Security & Access Control**: Role-Based Access Control (RBAC) using Spatie Laravel Permission
- ✅ **Audit Trails & Activity Logging**: Logs all user actions for transparency
- ✅ **Modern UI & Notifications**: Built with Vue.js, TailwindCSS, and SurveyJS

### Technology Stack
- **Laravel** (Backend)
- **Vue.js** (Frontend)
- **MySQL** (Database)
- **SurveyJS** (Survey management)
- **Spatie Laravel Permission** (RBAC)
- **Laravel Fortify** (Authentication)
- **Vite** (Frontend asset bundling)

---

## Installation Guide ([Full Guide](docs/installation-guide.md))
1. **Clone the repository**
   ```sh
   git clone https://github.com/shahrilazwa/digital-services-survey.git
   cd digital-services-survey
   ```
2. **Install dependencies**
   ```sh
   composer install
   npm install
   ```
3. **Configure `.env` file**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. **Run migrations and seed database**
   ```sh
   php artisan migrate --seed
   ```
5. **Start the development server**
   ```sh
   php artisan serve
   npm run dev
   ```

---

## Documentation
- 📄 [Activity Notifications](docs/activity-notifications.md)
- 📄 [Audit Trails](docs/audit-trails.md)
- 📄 [Create New Form](docs/create-new-form.md)
- 📄 [Create New Page](docs/create-new-page.md)
- 📄 [Form Validation](docs/form-validation.md)
- 📄 [Roles & Permissions](docs/roles-permissions.md)
- 📄 [Survey Management](docs/survey-management.md)
- 📄 [Toast Notifications](docs/toast-notifications.md)

---

## Contribution Guidelines ([Full Guide](docs/contribution.md))
We welcome contributions! Follow these steps:
1. Fork the repository
2. Create a new branch (`git checkout -b feature-branch-name`)
3. Commit your changes (`git commit -m "Describe your changes"`)
4. Push to your branch (`git push origin feature-branch-name`)
5. Submit a pull request (PR)

---

## License
This project is licensed under the **MIT License**.

**GitHub Repository**: [Digital Services Survey](https://github.com/shahrilazwa/digital-services-survey)
