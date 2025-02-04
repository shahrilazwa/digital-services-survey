import { createApp } from 'vue';

(function () {
    "use strict";

    let previousApp = null; // Track the previously mounted Vue app

    document.addEventListener("DOMContentLoaded", () => {
        const schemaCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const selectedSchemaId = document.querySelector('input[name="selected-schema-id"]').value; // Correct input name
        const nextButton = document.getElementById('next-button');
        const viewButtons = document.querySelectorAll('[data-tw-toggle="modal"]');

        let selectedSchema = null;

        // Pre-select the schema if `schema_id` exists
        schemaCheckboxes.forEach((checkbox) => {
            const parentTd = checkbox.closest('td[data-schema-id]');
            if (parentTd) {
                const schemaId = parentTd.dataset.schemaId;

                // Ensure both values are strings for comparison
                if (schemaId === selectedSchemaId) {
                    checkbox.checked = true;
                    selectedSchema = {
                        id: schemaId,
                        title: parentTd.dataset.schemaTitle,
                    };

                    // Disable all other checkboxes
                    schemaCheckboxes.forEach((cb) => {
                        if (cb !== checkbox) {
                            cb.disabled = true;
                        }
                    });
                }

                // Add change event listener for manual selection
                checkbox.addEventListener("change", (event) => {
                    if (event.target.checked) {
                        selectedSchema = {
                            id: schemaId,
                            title: parentTd.dataset.schemaTitle,
                        };

                        // Disable other checkboxes
                        schemaCheckboxes.forEach((cb) => {
                            if (cb !== event.target) {
                                cb.disabled = true;
                            }
                        });
                    } else {
                        // Enable all checkboxes if none are selected
                        schemaCheckboxes.forEach((cb) => (cb.disabled = false));

                        // Clear the selection
                        selectedSchema = null;
                    }
                });
            }
        });

        // Handle the "Next" button click
        if (nextButton) {
            nextButton.addEventListener("click", async (event) => {
                event.preventDefault();

                if (!selectedSchema) {
                    alert("Please select a schema before proceeding.");
                    return;
                }

                try {
                    console.log("Submitting Data:", selectedSchema);

                    // Construct the URL dynamically for the specific survey
                    const surveyId = document.querySelector('input[name="survey-id"]').value;
                    const response = await axios.put(
                        `/publish-surveys/${surveyId}/store-schema`,
                        selectedSchema
                    );

                    // Redirect to the next step if successful
                    if (response.status === 201 && response.data.success) {
                        console.log(response.data.message);
                        window.location.href = response.data.redirect; // Redirect to next step
                    } else {
                        alert("Failed to save schema details. Please try again.");
                    }
                } catch (error) {
                    console.error("Error while saving schema:", error);
                    alert("An error occurred while saving the schema details. Please try again.");
                }
            });
        }

        // Handle the "View" buttons for schemas
        viewButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();
                const surveyId = button.getAttribute("data-survey-id");
                const modalSurveyContent = document.getElementById("modal-survey-content");
                const modalSurveyApp = document.getElementById("survey-viewer-modal-app");

                // Clear existing survey content
                modalSurveyApp.innerHTML = "";

                // Unmount the previous app if it exists
                if (previousApp) {
                    previousApp.unmount();
                    previousApp = null; // Reset previous app
                }

                try {
                    // Fetch survey data using axios
                    const response = await axios.get(`/schemas/${surveyId}/data`);
                    const schemaData = response.data;

                    // Dynamically import the SurveyViewer component
                    const SurveyViewer = (
                        await import("/resources/js/components/vue/SchemaViewer.vue")
                    ).default;

                    // Create and mount the Vue app
                    previousApp = createApp(SurveyViewer, { schemaData });
                    previousApp.mount("#survey-viewer-modal-app");
                } catch (error) {
                    modalSurveyContent.innerHTML =
                        '<p class="text-red-500">Failed to load survey. Please try again later.</p>';
                    console.error("Error loading survey data:", error);
                }
            });
        });
    });
})();