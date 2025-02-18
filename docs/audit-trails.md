# **Audit Trail Documentation**  

## **Overview**  
This document provides a comprehensive explanation of the **audit trail system** implemented in the **Digital Services Survey** project. The system ensures **accountability, security, and transparency** by logging key user activities related to **roles, permissions, surveys, and other entities**.  

The project utilizes a **custom helper class** called `ActivityLogger`, which records actions performed by users and stores them in the `activity_logs` table.  

---

## **Tracked Activities**  
The audit trail system logs critical actions performed by users, including the creation, updating, and deletion of various entities.  

### **1. User Management**  
- **Create User** – Logged when a new user is added to the system.  
- **Update User** – Logged when user details are modified.  
- **Delete User** – Logged when a user is removed.  

### **2. Role & Permission Management**  
- **Create Role** – Logged when a new role is added.  
- **Update Role** – Logged when a role is modified.  
- **Delete Role** – Logged when a role is deleted.  
- **Create Permission** – Logged when a new permission is created.  
- **Update Permission** – Logged when a permission is modified.  
- **Delete Permission** – Logged when a permission is deleted.  

### **3. Survey Schema Management**  
- **Create Survey Schema** – Logged when a new schema is designed.  
- **Update Survey Schema** – Logged when an existing schema is modified.  
- **Approve Survey Schema** – Logged when a schema is reviewed and approved.  
- **Delete Survey Schema** – Logged when a schema is removed.  

### **4. Survey Publication**  
- **Publish Survey** – Logged when a survey is published.  
- **Close Survey** – Logged when a published survey is closed.  

### **5. Survey Results**  
- **Submit Survey Response** – Logged when a user submits a survey response.  
- **Update Survey Response** – Logged when a survey response is modified.  

---

## **Audit Log Table Structure**  
All activities are stored in the `activity_logs` table, which maintains a detailed record of user actions.  

| **Column**       | **Data Type** | **Description** |
|------------------|-------------|----------------|
| `id`            | `BIGINT`     | Unique identifier for each log entry. |
| `user_id`       | `BIGINT`     | The ID of the user who performed the action. |
| `action`        | `STRING`     | The type of action performed (`Created`, `Updated`, `Deleted`). |
| `entity_type`   | `STRING`     | The name of the affected entity (e.g., `Permission`, `Role`, `Survey`). |
| `entity_id`     | `BIGINT`     | The ID of the affected entity. |
| `details`       | `JSON`       | Additional metadata related to the action. |
| `created_at`    | `TIMESTAMP`  | The date and time of the action. |

---

## **Role-Based Access to Audit Logs**  
Only **authorized users** can access and manage audit logs. Below is the access matrix:

| Permission | Survey Admin | Super Admin | Survey Manager | Survey Designer | Survey Reviewer | Survey Publisher | Survey Operator | Data Analyst |
|------------|-------------|-------------|---------------|----------------|----------------|----------------|----------------|--------------|
| View Audit Logs | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Manage Audit Logs | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |

✅ = Has permission | ❌ = No permission  

---

## **Integration in Controllers**  
The `ActivityLogger::log()` function is integrated into various controllers **to track changes automatically**.

### **Example Log Entry in `activity_logs` Table**  
```json
{
    "user_id": 5,
    "action": "Updated",
    "entity_type": "Permission",
    "entity_id": 12,
    "details": {
        "title": "Publish Survey",
        "description": "Permission updated to allow survey publication."
    },
    "created_at": "2025-02-18 12:30:45"
}
```

### **Logging Role Creation**  
```php
ActivityLogger::log('Created', 'Role', $role->id, [
    'title' => $role->name,
    'description' => $role->description,
]);
```

### **Logging Permission Updates**  
```php
ActivityLogger::log('Updated', 'Permission', $permission->id, [
    'title' => $permission->name,
    'description' => $permission->description,
]);
```

### **Logging Survey Schema Approvals**  
```php
ActivityLogger::log('Approved', 'Survey Schema', $schema->id, [
    'title' => $schema->title,
    'approved_by' => Auth::user()->name,
]);
```

### **Logging Deleted Permissions**  
```php
ActivityLogger::log('Deleted', 'Permission', $permission->id, [
    'title' => $permission->name,
    'description' => $permission->description,
]);
```

---

## **Conclusion**  
This document provides an overview of the audit trail implementation in the **Digital Services Survey** project. The structured approach ensures that **all key activities** are logged, improving **security, compliance, and accountability**.

For further inquiries or modifications, please contact the **Survey Admin** or **Super Admin** of the system.
