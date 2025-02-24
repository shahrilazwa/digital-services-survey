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
- 📄 [Contribution Guidelines](docs/contribution.md)

---

## Contribution Guidelines ([Full Guide](docs/contribution.md))

We welcome contributions! Follow these steps:

### How to Contribute

1. **Fork the Repository**: Click the `Fork` button on GitHub to create your own copy.
2. **Clone Your Fork**: Download your forked repository to your local machine.
   ```sh
   git clone https://github.com/your-username/digital-services-survey.git
   cd digital-services-survey
   ```
3. **Create a New Branch**: Work on a new feature or bug fix in a separate branch.
   ```sh
   git checkout -b feature-branch-name
   ```
4. **Make Your Changes**: Modify the code, documentation, or tests as needed.
5. **Commit and Push**: Save your changes and push them to GitHub.
   ```sh
   git add .
   git commit -m "Describe your changes"
   git push origin feature-branch-name
   ```
6. **Submit a Pull Request (PR)**: Go to your forked repository on GitHub and click `New Pull Request`.

### Code Style Guidelines

- Follow the Laravel and Vue.js best practices.
- Write clear and descriptive commit messages.
- Ensure your changes do not break existing functionality.

### Reporting Issues

If you find a bug or have a feature request, create an issue [here](https://github.com/shahrilazwa/digital-services-survey/issues).

---

## License

This project is licensed under the **MIT License**.

**GitHub Repository**: [Digital Services Survey](https://github.com/shahrilazwa/digital-services-survey)
