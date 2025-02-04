(function () {
    "use strict";

    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null; 

    function onSubmit(pristine, form, redirectUrl = null, completedStep = null) {
        let valid = pristine.validate();
        
        if (valid) {
            let formData = {
                title: getInputValue(form, 'input[name="schema-title"]'),
                description: getInputValue(form, 'textarea[name="schema-desc"]'),
                completed_steps: completedStep
            }; 
            console.log("Submitting Data:", formData);
            axios.post('/schemas', formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
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
            console.log('Completed Steps:', response.data.completed_steps);
            sessionStorage.setItem('status', response.data.status);
            sessionStorage.setItem('message', response.data.message);
            sessionStorage.setItem('details', response.data.details);
            window.location.href = redirectUrl || `/schemas/${response.data.id}/design`;
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
            let step = this.querySelector('button[type="submit"]').getAttribute('data-step');
            onSubmit(pristine, this, '/schemas/create/design', step);
        });

        document.querySelector('button[name="btn-schema-design"]').addEventListener('click', function (e) {
            e.preventDefault();
            let form = document.querySelector('.validate-form');
            let step = this.getAttribute('data-step');
            let nextUrl = this.getAttribute('data-redirect');
            onSubmit(pristine, form, nextUrl, step);
        });      
    }); 
    
})();