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
    
    // Success notification after page reload
    let successMessageElement = $("#success-message");
    if (successMessageElement.length > 0) {  // Ensure element exists
        Toastify({
            node: $("#success-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    };

    // Error notification after page reload
    let errorMessageElement = $("#error-message");
    if (errorMessageElement.length > 0) {  // Ensure element exists
        Toastify({
            node: $("#error-notification-content")
                .clone()
                .removeClass("hidden")[0],
            duration: -1,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    };      

})();