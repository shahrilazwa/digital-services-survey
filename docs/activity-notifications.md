# **Activity Notifications for Logged-In Users**

## **Overview**
This document establishes the **standardized approach** for implementing **activity notifications** in the **Digital Services Survey** project. 

Activity notifications provide **real-time feedback** to users about their recent actions within the system, ensuring **transparency and traceability**.

By implementing this feature, we achieve:
- ✅ **Enhanced user awareness** of recent changes.
- ✅ **Consistency** in displaying notifications across the system.
- ✅ **Efficient data retrieval** by limiting results to the latest 5 activities.
- ✅ **Secure access control** ensuring that users only see their own activities.

---

## **Data Source: Activity Logs**
Activity notifications are fetched from the `activity_logs` table.

### **Table Structure: `activity_logs`**
| **Column**       | **Data Type** | **Description** |
|------------------|-------------|----------------|
| `id`            | `BIGINT`     | Unique identifier for each activity log. |
| `user_id`       | `BIGINT`     | The ID of the user who performed the action. |
| `action`        | `STRING`     | The type of action performed (`Created`, `Updated`, `Deleted`). |
| `entity_type`   | `STRING`     | The entity affected by the action (e.g., `Permission`, `Role`). |
| `entity_id`     | `BIGINT`     | The ID of the affected entity. |
| `details`       | `JSON`       | Additional metadata related to the action. |
| `created_at`    | `TIMESTAMP`  | The date and time of the action. |

---

## **Fetching Activity Logs in `AppServiceProvider`**
To ensure **consistent availability** of notifications across all views, we use **view composers** to fetch activity logs.

📂 **File:** `app/Providers/AppServiceProvider.php`
```php
use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fetch the latest 5 activity logs for the logged-in user
        View::composer('components.themes.rubick.top-bar.index', function ($view) {
            $activities = ActivityLog::where('user_id', Auth::id())
                ->latest()
                ->limit(5)
                ->get();
            $view->with('activities', $activities);
        });
    }
}
```

### **Explanation**
- **Why use `View::composer`?**
  - Ensures that activity logs are **always available** in the top bar **without explicitly fetching them** in every controller.
  - Improves **code maintainability** by centralizing data retrieval.

- **Fetching the latest 5 logs**
  - Uses `where('user_id', Auth::id())` to retrieve only the logged-in user’s activities.
  - Uses `latest()->limit(5)` to ensure efficiency and prevent excessive queries.

---

## **Displaying Notifications in the Top Bar**
Activity notifications are displayed in the top bar **dynamically**.

📂 **File:** `resources/views/components/themes/rubick/top-bar/index.blade.php`
```blade
<!-- BEGIN: Notifications -->
<x-base.popover class="intro-x mr-auto sm:mr-6">
    <x-base.popover.button
        class="relative block text-slate-600 outline-none before:absolute before:right-0 before:top-[-2px] before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-['']"
    >
        <x-base.lucide class="h-5 w-5 dark:text-slate-500" icon="Bell" />
    </x-base.popover.button>
    <x-base.popover.panel class="mt-2 w-[280px] p-5 sm:w-[350px]">
        <div class="mb-5 font-medium">Notifications</div>
        @forelse ($activities as $activity)
            <div class="relative flex items-center mt-3">
                <div class="image-fit relative mr-1 h-12 w-12 flex-none">
                    <img
                        class="rounded-full"
                        src="{{ asset('images/user-default.png') }}"
                        alt="User Avatar"
                    />
                    <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-success dark:border-darkmode-600">
                    </div>
                </div>
                <div class="ml-2 overflow-hidden">
                    <div class="flex items-center">
                        <a class="mr-5 truncate font-medium" href="#">
                            {{ $activity->action }}
                        </a>
                        <div class="ml-auto whitespace-nowrap text-xs text-slate-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="mt-0.5 w-full truncate text-slate-500">
                        {{ $activity->details['description'] ?? 'No details available' }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500 text-center">No recent activities</p>
        @endforelse
    </x-base.popover.panel>
</x-base.popover>
<!-- END: Notifications -->
```

### **Explanation**
- **Using `@forelse` instead of `@foreach`**
  - Ensures **graceful handling** when there are no activity logs.
  - Displays `"No recent activities"` instead of an empty section.

- **Using `{{ $activity->created_at->diffForHumans() }}`**
  - Displays timestamps in a **human-readable format** (e.g., `"2 hours ago"` instead of `"2024-03-01 12:30:00"`).

- **Handling Missing Details Gracefully**
  - If `details['description']` is missing, it displays `"No details available"` instead of breaking the layout.

---

## **Customizing the User Avatar**
By default, the **user avatar** is set to a placeholder image.

#### **Change Placeholder Avatar to Actual User Image**
```blade
<img
    class="rounded-full"
    src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/user-default.png') }}"
    alt="User Avatar"
/>
```

✅ **How It Works**:
- If the user has a profile image (`Auth::user()->profile_image`), it displays that.
- If not, it **falls back** to `user-default.png`.

---

## **Summary of the Standard**
| Component | Standard |
|------------|-------------|
| **Fetching Logs** | Use `View::composer()` to fetch logs **globally**. |
| **Number of Logs** | Limit to the **latest 5** logs per user. |
| **Display Logic** | Use `@forelse` to handle **empty states gracefully**. |
| **Date Formatting** | Use `diffForHumans()` for **better readability**. |
| **User Avatar Handling** | Fallback to `user-default.png` if no profile image is available. |

---

## **Conclusion**
By following this **standardized approach**, we ensure:
- ✅ **Users stay informed** about their actions.
- ✅ **Consistent UI behavior** for notifications.
- ✅ **Efficient data retrieval** with a limit on query results.
- ✅ **Scalability** as more activities are logged in the future.

For further modifications, contact the **Survey Admin** or **Super Admin**. 🚀
