(function () {
    "use strict";

    const surveySchema = window.AppData?.surveySchema;

    function onSubmit(pristine, form, redirectUrl = null, completedStep = null) {
        let valid = pristine.validate();

        if (valid) {
            let schemaData = typeof surveySchema?.schema_json === "string" 
                ? surveySchema.schema_json 
                : JSON.stringify(surveySchema.schema_json);

            let formData = {
                schema_data: schemaData,
                completed_steps: completedStep,
            };

            console.log("Submitting Data:", formData);

            axios
                .post(`/schemas/${surveySchema?.id}/design`, formData)
                .then((response) => handleSuccess(response, redirectUrl))
                .catch((error) => handleError(error));
        } else {
            Toastify({
                node: $("#failed-notification-content").clone().removeClass("hidden")[0],
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
        }
    }

    // Success handler
    function handleSuccess(response, redirectUrl) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.data.message);
            console.log("Completed Steps:", response.data.completed_steps);

            sessionStorage.setItem("status", response.data.status);
            sessionStorage.setItem("message", response.data.message);
            sessionStorage.setItem("details", response.data.details);

            // Redirect to the provided URL or the default next step
            window.location.href = redirectUrl || `/schemas/${response.data.id}/team`;
        }
    }

    // Error handler
    function handleError(error) {
        if (error.response && error.response.status === 422) {
            console.log("Validation Errors:", error.response.data.errors);
        } else {
            console.error("An error occurred:", error.response?.data || error.message);
        }
    }

    $(".validate-form").each(function () {
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        // Form submission handler
        $(this).on("submit", function (e) {
            e.preventDefault();

            // Get the redirect URL and step from the currently active submit button
            const submitButton = e.originalEvent.submitter;
            const step = submitButton?.getAttribute("data-step");
            const redirectUrl = submitButton?.getAttribute("data-redirect");

            // Submit the form
            onSubmit(pristine, this, redirectUrl, step);
        });

        // Generic handler for wizard buttons (Next/Previous)
        document.querySelectorAll("button[name^='btn-schema-']").forEach((button) => {
            button.addEventListener("click", function (e) {
                e.preventDefault();

                const form = document.querySelector(".validate-form");
                const step = this.getAttribute("data-step");
                const redirectUrl = this.getAttribute("data-redirect");

                // Submit the form with updated step and redirect URL
                onSubmit(pristine, form, redirectUrl, step);
            });
        });
    });
})();