# Roles and Permissions Documentation

## Overview
This document provides a comprehensive explanation of the roles and permissions used in the **Digital Services Survey** project. The project utilizes **Spatie** and **Laravel Fortify** for Role-Based Access Control (RBAC), ensuring a structured and secure access management system.

## Roles
Roles in this system define the level of access users have to different functionalities. Below are the key roles available:

### 1. **Survey Admin**
   - Has full control over surveys, users, and system configurations.
   - Can manage roles and permissions.
   - Responsible for overseeing the entire survey management process.

### 2. **Super Admin**
   - Has unrestricted access to all functionalities.
   - Can assign and revoke any roles or permissions.
   - Typically assigned to system administrators.

### 3. **Survey Manager**
   - Manages survey teams and assigns roles within the project.
   - Approves survey schemas before publication.
   - Reviews survey responses and analytics.

### 4. **Survey Designer**
   - Responsible for designing survey schemas and structuring questions.
   - Can create and update survey schemas.
   - Cannot publish surveys but can submit them for approval.

### 5. **Survey Reviewer**
   - Reviews and provides feedback on survey schemas.
   - Ensures compliance with data collection standards.
   - Cannot modify schemas but can approve or reject submissions.

### 6. **Survey Publisher**
   - Has permission to publish approved survey schemas.
   - Can set start and end dates for survey availability.
   - Manages the deployment of surveys.

### 7. **Survey Operator**
   - Manages survey execution and monitors responses.
   - Can assist in survey distribution.
   - Views survey results but cannot modify schemas.

### 8. **Data Analyst**
   - Access to survey response data for analysis and reporting.
   - Cannot modify surveys but can generate insights and reports.

## Permissions
Each role is assigned specific permissions that define what actions a user can perform. Below are the key permissions categorized by functionality:

### **User Management**
- `create users`
- `view users`
- `update users`
- `delete users`

### **Role & Permission Management**
- `create roles`
- `view roles`
- `update roles`
- `delete roles`
- `create permissions`
- `view permissions`
- `update permissions`
- `delete permissions`

### **Survey Schema Management**
- `create survey schema`
- `view survey schema`
- `update survey schema`
- `delete survey schema`
- `approve survey schema`

### **Survey Publication**
- `publish surveys`
- `view published surveys`
- `close surveys`

### **Survey Results**
- `view survey results`
- `analyze survey results`
- `export survey data`

## Role-Permission Mapping
The table below outlines which roles have access to specific permissions:

| Permission | Survey Admin | Super Admin | Survey Manager | Survey Designer | Survey Reviewer | Survey Publisher | Survey Operator | Data Analyst |
|------------|-------------|-------------|---------------|----------------|----------------|----------------|----------------|--------------|
| create users | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| view users | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| update users | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| delete users | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| create survey schema | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| view survey schema | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| approve survey schema | ✅ | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |
| publish surveys | ✅ | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| view survey results | ✅ | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ | ✅ |
| analyze survey results | ✅ | ✅ | ❌ | ❌ | ✅ | ✅ | ✅ | ✅ |

✅ = Has permission | ❌ = No permission

## Conclusion
This document serves as a guide to understanding the role-based access control implemented in the **Digital Services Survey** project. The structured approach ensures that users only have access to functionalities relevant to their roles, enhancing security and efficiency.

For further inquiries or modifications, please contact the **Survey Admin** or **Super Admin** of the system.

