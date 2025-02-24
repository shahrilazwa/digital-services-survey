# 📜 **Survey Management Guide**

## **Overview**
The **Digital Services Survey System** provides a **structured way to create, manage, and publish surveys** to collect feedback on government digital services. Surveys are designed using **reusable schemas**, making it easy to update and maintain consistency across multiple surveys.

This document provides a **step-by-step guide** on how to:

- ✔️ **Create a Survey Schema**  
- ✔️ **Edit & Manage Existing Surveys**  
- ✔️ **Publish a Survey** (Generate a shareable link)  
- ✔️ **Distribute the Survey** (Embed links in external applications)  
- ✔️ **Collect & Export Responses**  

---

## 📌 **1️⃣ Creating a New Survey Schema**
A **Survey Schema** is a **template** containing questions and settings that can be reused across multiple surveys.

### **Steps to Create a Survey Schema**
1. **Navigate to the "Survey Management" section** in the **Admin Panel**.
2. Click on the **"Create New Survey"** button.
3. Enter the **Survey Name** (e.g., "User Satisfaction Survey").
4. Select the **Survey Category** (e.g., "E-Government Services").
5. Add **Survey Questions**:
   - Choose **question type** (Multiple Choice, Text, Rating, etc.).
   - Add **possible answers** (if applicable).
   - Define **whether a question is required or optional**.
6. Click **Save Survey**.

📌 **Example:**
| Field | Example Value |
|--------|----------------|
| Survey Name | Government Website Feedback |
| Category | Public Services |
| Question 1 | How satisfied are you with the website? (Rating 1-5) |
| Question 2 | What could be improved? (Open-ended response) |

---

## 📌 **2️⃣ Editing & Managing Existing Surveys**
Admins can **edit, duplicate, or delete** surveys from the **Survey List** page.

### **Editing a Survey**
- Click **"Edit"** next to the survey in the list.
- Modify **questions, categories, or settings**.
- Save changes.

### **Deleting a Survey**
- Click **"Delete"** on an existing survey.
- Confirm deletion (⚠️ This action is irreversible).

💡 **Reminder:** Editing a survey **does not affect already collected responses**.

---

## 📌 **3️⃣ Publishing a Survey**
Once a survey **schema is ready**, it can be **published** to collect responses.

### **Steps to Publish a Survey**
1. **Go to the Survey List page**.
2. Find the survey schema and click **"Publish"**.
3. A **unique survey link** will be generated (e.g., `https://survey.gov/response/xyz123`).
4. Share this **link with users**.

📌 **Example Survey Link:**
```
https://survey.gov/response/xyz123
```

💡 **Reminder:** Published surveys **cannot be modified**. If changes are needed, **unpublish, edit, and republish**.

---

## 📌 **4️⃣ Distributing the Survey**
Once the **survey link** is generated, it can be **shared** via:
- 📧 **Email Campaigns** – Include the link in newsletters.
- 🌐 **Government Websites** – Embed the survey in service portals.
- 📱 **Mobile Applications** – Add links to in-app surveys.
- 📢 **Social Media & SMS** – Share via WhatsApp, Facebook, or text messages.

📌 **Embedding the Survey in a Portal**
```html
<a href="https://survey.gov/response/xyz123" target="_blank">
   Take Our Survey
</a>
```

💡 **Reminder:** Users do not need an account to respond.

---

## 📌 **5️⃣ Collecting & Exporting Responses**
Admins can **monitor responses in real time** and **export data for further analysis**.

### **Viewing Survey Responses**
1. **Navigate to the "Survey Responses" section**.
2. Select the **published survey**.
3. View **response statistics** (charts, summaries, and filters).

### **Exporting Responses**
Responses can be exported in **CSV format** directly from the **SurveyJS component in the UI**.

📌 **Steps to Export Responses:**
1. Navigate to the **Survey Responses** section.
2. Click on the **Export** button in the UI.
3. Select **CSV Format**.
4. Download the exported responses.

✔️ **CSV Format** – Suitable for spreadsheets and databases.  
❌ **Excel Format (XLSX)** – Not supported yet.

💡 **Reminder:** The export function is available **only through the UI**.

---

## **🔹 Summary**
| **Step** | **Action** |
|----------|-------------------------|
| **1️⃣ Create Survey Schema** | Define survey structure & questions. |
| **2️⃣ Edit or Delete Surveys** | Modify or remove existing surveys. |
| **3️⃣ Publish Survey** | Generate a **unique survey link**. |
| **4️⃣ Distribute Survey** | Share via email, website, social media, etc. |
| **5️⃣ Collect Responses** | View & export responses in **CSV format via the UI**. |

---

## **🚀 Conclusion**
By following this guide, agencies can:
- ✔️ **Efficiently create and reuse surveys**  
- ✔️ **Easily publish & distribute surveys via a shareable link**  
- ✔️ **Collect valuable feedback for service improvement**  

💡 **Reminder:** Always test your survey **before publishing** to ensure a smooth user experience.  

🚀 **Happy Surveying!** 🚀
