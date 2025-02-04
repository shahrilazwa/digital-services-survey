(function () {
    "use strict";

    document.addEventListener('DOMContentLoaded', function () {
        const message = sessionStorage.getItem('message');
        const details = sessionStorage.getItem('details');

        if (message) {
            const notificationTemplate = document.getElementById("notification-content");
            const notificationNode = notificationTemplate.cloneNode(true);

            // Ensure the cloned node is a DOM element
            if (notificationNode.nodeType === 1) {
                notificationNode.classList.remove("hidden");

                const toastTitle = notificationNode.querySelector("#toast-title");
                const toastDetails = notificationNode.querySelector("#toast-details");

                if (toastTitle) {
                    toastTitle.textContent = message;
                }

                if (toastDetails && details) {
                    toastDetails.textContent = `${details} successfully created!`;
                }

                Toastify({
                    node: notificationNode,
                    duration: 6000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                }).showToast();

                sessionStorage.removeItem('message');
                sessionStorage.removeItem('details');
            }
        }
    });
})();