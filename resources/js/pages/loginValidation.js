(function () {
    "use strict";
    
    function onSubmit(pristine, form) {
        let valid = pristine.validate();
        
        if (valid) {
            // Prepare form data for AJAX submission
            let formData = {
                email: form.querySelector('input[name="email"]').value,
                password: form.querySelector('input[name="password"]').value,
                // remember: form.querySelector('input[name="remember"]')?.checked ? 'on' : null,  // Optional remember me
            };
            console.log(formData);
            // Perform AJAX request to Fortify's login route
            axios.post('/login', formData)
                .then(function (response) {
                    if (response.status === 200) {
                        console.log(response.status);
                        window.location.href = '/dashboard';
                    }
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        // On validation error (HTTP 422), show error message
                        const errors = error.response.data.errors;

                        // Display validation errors for email and password
                        if (errors.email) {
                            console.error('Email error:', errors.email[0]);
                        }
                        if (errors.password) {
                            console.error('Password error:', errors.password[0]);
                        }

                        // On failure, display error message using Toastify
                        Toastify({
                            node: $("#failed-notification-content")
                                .clone()
                                .removeClass("hidden")[0],
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                        }).showToast();
                    }
                });
        } else {
            Toastify({
                node: $("#failed-notification-content")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
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
