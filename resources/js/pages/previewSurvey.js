import { createApp } from 'vue';

(function () {
    "use strict";

    let previousApp = null; // Track the previously mounted Vue app

    document.addEventListener("DOMContentLoaded", () => {
        const viewButtons = document.querySelectorAll('[data-tw-toggle="modal"]');

        viewButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();

                const schemaId = button.getAttribute("data-schema-id");
                const modalSchemaContent = document.getElementById("modal-schema-content");
                const modalSchemaApp = document.getElementById("schema-viewer-modal-app");

                // Clear existing schema content
                modalSchemaApp.innerHTML = "";

                // Unmount the previous app if it exists
                if (previousApp) {
                    previousApp.unmount();
                    previousApp = null; // Reset previous app
                }

                try {
                    // Fetch schema data using axios
                    const response = await axios.get(`/schemas/${schemaId}/data`);
                    const schemaData = response.data;

                    // Dynamically import the SchemaViewer component
                    const SchemaViewer = (await import("/resources/js/components/vue/SchemaViewer.vue")).default;

                    // Create and mount the Vue app
                    previousApp = createApp(SchemaViewer, { schemaData });
                    previousApp.mount("#schema-viewer-modal-app");
                } catch (error) {
                    modalSchemaContent.innerHTML =
                        '<p class="text-red-500">Failed to load schema. Please try again later.</p>';
                    console.error("Error loading schema data:", error);
                }
            });
        });
    });
})();