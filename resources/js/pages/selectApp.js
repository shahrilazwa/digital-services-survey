(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", () => {
        const platformCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const nextButton = document.getElementById('next-button');
        const preselectedPlatformId = document.querySelector('input[name="selected-platform-id"]')?.value; // Retrieve the preselected platform ID
        let selectedPlatform = null;

        // Pre-select the checkbox and disable others if a preselected platform exists
        if (preselectedPlatformId) {
            platformCheckboxes.forEach((checkbox) => {
                const parentTd = checkbox.closest('td[data-platform-id]');
                if (parentTd && parentTd.dataset.platformId === preselectedPlatformId) {
                    checkbox.checked = true;
                    checkbox.disabled = false;

                    // Disable other checkboxes
                    platformCheckboxes.forEach((cb) => {
                        if (cb !== checkbox) {
                            cb.disabled = true;
                        }
                    });

                    // Set the selectedPlatform object
                    selectedPlatform = {
                        id: preselectedPlatformId,
                        title: parentTd.dataset.platformTitle,
                    };
                }
            });
        }

        // Add change event listeners to checkboxes
        platformCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
                const parentTd = event.target.closest('td[data-platform-id]');
                if (event.target.checked && parentTd) {
                    // Set the selected platform
                    selectedPlatform = {
                        id: parentTd.dataset.platformId,
                        title: parentTd.dataset.platformTitle,
                    };

                    // Disable other checkboxes
                    platformCheckboxes.forEach((cb) => {
                        if (cb !== event.target) {
                            cb.disabled = true;
                        }
                    });
                } else {
                    // Enable all checkboxes if none are selected
                    platformCheckboxes.forEach((cb) => (cb.disabled = false));

                    // Clear the selection
                    selectedPlatform = null;
                }
            });
        });

        // Handle the "Next" button click
        if (nextButton) {
            nextButton.addEventListener("click", async (event) => {
                event.preventDefault();

                if (!selectedPlatform) {
                    alert("Please select a platform before proceeding.");
                    return;
                }

                try {
                    // Send the selected platform to the server
                    const surveyId = document.querySelector('input[name="survey-id"]').value;
                    const response = await axios.post(`/publish-surveys/${surveyId}/store-app`, selectedPlatform);

                    if (response.status === 201 && response.data.success) {
                        console.log(response.data.message);
                        window.location.href = response.data.redirect; // Redirect to the next step
                    } else {
                        alert("Failed to save platform details. Please try again.");
                    }
                } catch (error) {
                    console.error("Failed to save platform details:", error);
                    alert("An error occurred while saving the platform details. Please try again.");
                }
            });
        } else {
            console.warn("Next button not found in the DOM. Event listener not added.");
        }
    });
})();