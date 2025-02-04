(function () {
    "use strict";

    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                title: getInputValue(form, 'input[name="survey-title"]'),
                description: getInputValue(form, 'textarea[name="survey-desc"]'),
            };
            console.log("Submitting Data:", formData);
            axios.post('/publish-surveys', formData)
                 .then(response => handleSuccess(response))
                 .catch(error => handleError(error));
        } else {
            showToast('Please correct the highlighted errors and try again.', 'error');
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            window.location.href = response.data.redirect;
        }
    }

    // Error handler
    function handleError(form, error) {
        if (error.response && error.response.status === 422) {
            Object.keys(error.response.data.errors).forEach(field => {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    pristine.addError(input, error.response.data.errors[field][0]);
                }
            });
        } else {
            showToast('An unexpected error occurred.', 'error');
            console.error(error);
        }
    }

    function showToast(message, type = 'info') {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: type === 'success' ? 'green' : type === 'error' ? 'red' : 'blue',
            },
            stopOnFocus: true,
        }).showToast();
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