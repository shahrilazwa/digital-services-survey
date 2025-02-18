### **Audit Trail Documentation**

---

## **1️⃣ Overview**  
The **Digital Services Survey** project implements an **audit trail (activity logging)** system to **track critical user actions** within the application. This ensures **transparency, accountability, and security** by recording all **role, permission, and survey-related activities**.

The audit trail functionality is powered by a **custom helper class** called `ActivityLogger`, which logs user activities in the `activity_logs` table.

---

## **2️⃣ Tracked Activities**  
The system records activities related to **roles, permissions, users, and surveys**.

| **Entity**          | **Actions Logged** |
|---------------------|-------------------|
| **Users**          | Created, Updated, Deleted |
| **Roles**          | Created, Updated, Deleted |
| **Permissions**     | Created, Updated, Deleted |
| **Survey Schema**  | Created, Updated, Approved, Deleted |
| **Published Surveys** | Published, Closed, Reopened |
| **Survey Responses** | Submitted, Updated |

---

## **3️⃣ Audit Log Table Structure**  
All activities are stored in the `activity_logs` table.

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

## **4️⃣ How Audit Logging Works**  
The `ActivityLogger` helper class automatically logs activities **whenever a user creates, updates, or deletes records**.

✅ **Automatic tracking** of role, permission, and survey-related actions.  
✅ **Stores user information** to identify who performed each action.  
✅ **Includes JSON metadata** to provide additional context about changes.  

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

---

## **5️⃣ Integration in Controllers**  
The `ActivityLogger::log()` function is integrated into various controllers **to track changes automatically**.

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

## **6️⃣ Future Enhancements**  
📌 **Implement Soft Deletes** – Allow restoring deleted roles and permissions.  
📌 **Create an Audit Log UI** – Provide a dashboard to view activity logs in real time.  
📌 **Enhance Filtering** – Enable filtering logs by date, user, or entity type.  

---
