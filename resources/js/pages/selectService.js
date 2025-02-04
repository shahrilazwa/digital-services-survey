(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", () => {
        const serviceCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const nextButton = document.getElementById('next-button');

        let selectedService = null;

        // Handle checkbox selection
        serviceCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", (event) => {
                const parentTd = event.target.closest('td[data-service-id]');
                if (event.target.checked && parentTd) {
                    console.log('Digital Platform Service ID:', parentTd.dataset.digitalPlatformServiceId);
        
                    // Retrieve dataset attributes
                    selectedService = {
                        id: parentTd.dataset.serviceId,
                        title: parentTd.dataset.serviceTitle,
                        digitalPlatformServiceId: parentTd.dataset.digitalPlatformServiceId,
                    };
        
                    // Disable other checkboxes
                    serviceCheckboxes.forEach((cb) => {
                        if (cb !== event.target) {
                            cb.disabled = true;
                        }
                    });
                } else {
                    // Enable all checkboxes if none are selected
                    serviceCheckboxes.forEach((cb) => (cb.disabled = false));
        
                    // Clear selection
                    selectedService = null;
                }
            });
        });        

        // Handle "Next" button click
        if (nextButton) {
            nextButton.addEventListener("click", async (event) => {
                event.preventDefault();
            
                if (!selectedService) {
                    alert("Please select a service before proceeding.");
                    return;
                }
            
                console.log('Selected Service Object:', selectedService);
            
                try {
                    const surveyId = document.querySelector('input[name="survey-id"]').value;
                    const response = await axios.put(
                        `/publish-surveys/${surveyId}/store-service`, 
                        selectedService
                    );
            
                    if (response.status === 201 && response.data.success) {
                        console.log(response.data.message);
                        window.location.href = response.data.redirect;
                    } else {
                        alert("Failed to save service details. Please try again.");
                    }
                } catch (error) {
                    console.error("Failed to save service details:", error);
                    alert("An error occurred while saving the service details. Please try again.");
                }
            });
            
        }
    });
})();