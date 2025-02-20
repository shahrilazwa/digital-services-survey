(function () {
    "use strict";

    // Delete confirmation
    $("#delete-button").on("click", function () {
        Toastify({
            node: $("#delete-confirmation")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: false,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    });
    
    // Function to show Toast notifications and clear session values
    function showToastAndClearSession(type, messageElementId, notificationElementId) {

        let messageElement = $(`#${messageElementId}`);
        if (messageElement.length > 0) {  // Ensure element exists
            Toastify({
                node: $(`#${notificationElementId}`)
                    .clone()
                    .removeClass("hidden")[0],
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                callback: function () {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }).showToast();
        };
    }
      
    // Show and clear success notification
    showToastAndClearSession("success", "success-message", "success-notification-content");

    // Show and clear error notification
    showToastAndClearSession("error", "error-message", "error-notification-content");
})();