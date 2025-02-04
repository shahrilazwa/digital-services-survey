(function () {
    "use strict";

    async function updateCompletedSteps(step) {
        const surveySchema = window.AppData?.surveySchema;

        if (!surveySchema) {
            console.error("Survey schema data is missing.");
            return;
        }

        try {
            const response = await axios.post(`/schemas/${surveySchema.id}/update-step`, {
                current_step: step,
            });

            if (response.data && response.data.success) {
                console.log("Step updated successfully:", step);
            } else {
                console.error("Unexpected response:", response);
            }
        } catch (error) {
            console.error("Error updating completed steps:", error.response?.data || error.message);
        }
    }

    function onWizardButtonClick(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const redirectUrl = button.getAttribute("data-redirect");
        const step = button.getAttribute("data-step");

        if (step) {
            updateCompletedSteps(step).then(() => {
                if (redirectUrl) {
                    console.log(`Navigating to step: ${step}, URL: ${redirectUrl}`);
                    window.location.href = redirectUrl;
                } else {
                    console.error("No redirect URL specified for this button.");
                }
            });
        } else {
            console.error("No step specified for this button.");
        }
    }

    // Attach click event listeners to wizard buttons
    document.querySelectorAll("[name^='btn-schema-']").forEach((button) => {
        button.addEventListener("click", onWizardButtonClick);
    });

    document.getElementById("prevButton").addEventListener("click", function (event) {
        event.preventDefault();
        const surveySchema = window.AppData?.surveySchema;
        if (surveySchema) {
            updateCompletedSteps("Schema Preview").then(() => {
                window.location.href = `/schemas/${surveySchema.id}/team`;
            });
        }
    });

    document.getElementById("nextButton").addEventListener("click", function (event) {
        event.preventDefault();
        const surveySchema = window.AppData?.surveySchema;
        if (surveySchema) {
            updateCompletedSteps("Schema Preview").then(() => {
                window.location.href = `/schemas`;
            });
        }
    });
})();
