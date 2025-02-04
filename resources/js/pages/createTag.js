(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;     

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                title: getInputValue(form, 'input[name="tag-title"]'),
                description: getInputValue(form, 'textarea[name="tag-desc"]'),
            }            
            
            axios.post('/tags', formData)
            .then(response => handleSuccess(response))
            .catch(error => handleError(error));
        }
    }
    
    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            window.location.href = '/tags';
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