(function () {
    "use strict";
    
    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null; 

    function onSubmit(pristine, form) {
        let valid = pristine.validate();       

        if (valid) {
            let formData = {
                name: getInputValue(form, 'input[name="org-name"]'),
                abbr: getInputValue(form, 'input[name="org-abb"]'),
                type: getInputValue(form, 'select[name="orgTypes[]"]'),
                description: getInputValue(form, 'textarea[name="org-desc"]'),
            };
            console.log("Form Data:", formData);
            axios.post('/organizations', formData)
            .then(response => handleSuccess(response))
            .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            window.location.href = '/organizations';
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