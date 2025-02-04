(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    // Utility function to determine checkbox status
    const isCheckboxChecked = (form, selector) => form.querySelector(selector)?.checked || false;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let surveyId = getInputValue(form, 'input[name="survey-id"]');
            let formData = {
                survey_link: getInputValue(form, 'input[name="survey-link"]'),
                status: isCheckboxChecked(form, 'input[id="survey-status"]') ? 'Published' : 'Closed',
                start_date: formatDateToMySQL(getInputValue(form, 'input[id="start-date"]')),
                end_date: formatDateToMySQL(getInputValue(form, 'input[id="end-date"]')),
            };
            console.log("Submitting Data:", formData);
            axios({
                method: surveyId ? 'put' : 'post',
                url: surveyId ? `/publish-surveys/${surveyId}/publish` : '/publish-surveys',
                data: formData,
            })
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log("Survey published successfully:", response.data);
            window.location.href = '/publish-surveys';
        }
    }

    // Error handler
    function handleError(error) {
        if (error.response && error.response.status === 422) {
            console.log("Validation Errors:", error.response.data.errors);
        } else {
            console.error('An error occurred:', error.response?.data || error.message);
        }
    }

    // Format date to MySQL-compatible format
    function formatDateToMySQL(dateStr) {
        if (!dateStr) return null;
        
        const parsedDate = new Date(dateStr); 
        if (!isNaN(parsedDate)) {
            // Get local timezone offset in minutes and adjust
            const userOffset = parsedDate.getTimezoneOffset() * 60000;
            const adjustedDate = new Date(parsedDate.getTime() - userOffset);
            return adjustedDate.toISOString().split("T")[0];
        }
        return null;
    }
    

    $(".validate-form").each(function () {
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        // Custom validation for Start Date
        pristine.addValidator(
            this.querySelector("#start-date"),
            (value) => {
                const statusCheckbox = this.querySelector("#survey-status");
                if (statusCheckbox && statusCheckbox.checked) {
                    return value.trim() !== "";
                }
                return true;
            },
            "Start Date is required when survey is active.",
            2,
            false
        );

        // Custom validation for End Date
        pristine.addValidator(
            this.querySelector("#end-date"),
            (value) => {
                const statusCheckbox = this.querySelector("#survey-status");
                if (statusCheckbox && statusCheckbox.checked) {
                    return value.trim() !== "";
                }
                return true;
            },
            "End Date is required when survey is active.",
            2,
            false
        );

        $(this).on("submit", function (e) {
            e.preventDefault();
            onSubmit(pristine, this);
        });
    });

    // Copy Survey Link to Clipboard
    document.addEventListener("DOMContentLoaded", function () {
        const copyButton = document.getElementById("copy-link-btn");
        const surveyLinkInput = document.getElementById("survey-link");

        if (copyButton && surveyLinkInput) {
            copyButton.addEventListener("click", function () {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(surveyLinkInput.value)
                        .then(() => {
                            alert("Survey link copied to clipboard!");
                        })
                        .catch(err => {
                            console.error("Failed to copy:", err);
                            fallbackCopyText(surveyLinkInput.value); // Use fallback
                        });
                } else {
                    fallbackCopyText(surveyLinkInput.value); // Use fallback for unsupported browsers
                }
            });
        }
    });

    // Fallback method for older browsers
    function fallbackCopyText(text) {
        const tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Survey link copied to clipboard! (Fallback method)");
    }
})();