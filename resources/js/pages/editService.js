(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();
        if (valid) {
            // Prepare form data for AJAX submission
            let serviceId = getInputValue(form, 'input[name="service-id"]');
            let formData = {
                name: getInputValue(form, 'input[name="service-title"]'),
                description: getInputValue(form, 'textarea[name="service-desc"]'),
                tags: Array.from(form.querySelectorAll('select[name="tags[]"] option:checked')).map(option => option.value),
            };

            console.log("Form Data:", formData);

            axios.put(`/digital-services/${serviceId}`, formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.data.message);
            window.location.href = '/digital-services';
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
