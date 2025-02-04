(function () {
    "use strict";

    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                survey_title: getInputValue(form, 'input[name="survey-title"]'),
                survey_desc: getInputValue(form, 'textarea[name="survey-desc"]'),
            };

            console.log("Submitting Data to Session:", formData);

            // Post data to the new endpoint
            axios
                .post('/publish-surveys/store-details', formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        } else {
            // Show error notification
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
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.data.redirect);
            window.location.href = response.data.redirect;
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

    $(".validate-form").each(function () {
        let pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        $(this).on("submit", function (e) {
            e.preventDefault();
            onSubmit(pristine, this);
        });
    });
})();