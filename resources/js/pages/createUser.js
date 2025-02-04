(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    // Function to handle form submission
    function onSubmit(pristine, form) {
        const isValid = pristine.validate();

        if (isValid) {
            const placement = getInputValue(form, 'input[name="placement"]:checked');

            const formData = {
                name: getInputValue(form, 'input[name="user-name"]'),
                email: getInputValue(form, 'input[name="user-email"]'),
                personal_email: getInputValue(form, 'input[name="personal-email"]'),
                password: getInputValue(form, 'input[name="user-password"]'),
                password_confirmation: getInputValue(form, 'input[name="confirm-password"]'),
                user_type: getInputValue(form, 'select[name="userTypes[]"]'),
                placement,
                org_id: placement === "organization" ? getInputValue(form, 'select[name="organization"]') : null,
                agency_id: placement === "agency" ? getInputValue(form, 'select[name="agency"]') : null,
                roles: Array.from(form.querySelectorAll('select[name="roles[]"] option:checked')).map(option => option.value),
            };

            console.log("Form Data:", formData);

            axios.post('/users', formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            window.location.href = '/users'; // Redirect to user list on success
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

    // Toggle visibility of agency and organization dropdowns
    function toggleDropdowns() {
        const placement = document.querySelector('input[name="placement"]:checked')?.value;
        const agencyDropdown = $('#agcyDropdown');
        const orgDropdown = $('#orgDropdown');

        if (placement === 'organization') {
            orgDropdown.removeClass('hidden');
            agencyDropdown.addClass('hidden');
            $('#agcyDropdown select').val(''); // Clear agency selection
        } else if (placement === 'agency') {
            agencyDropdown.removeClass('hidden');
            orgDropdown.addClass('hidden');
            $('#orgDropdown select').val(''); // Clear organization selection
        } else {
            // Default: Hide both dropdowns
            agencyDropdown.addClass('hidden');
            orgDropdown.addClass('hidden');
        }
    }

    // Attach toggle event listeners
    document.querySelectorAll('input[name="placement"]').forEach(radio => {
        radio.addEventListener('click', toggleDropdowns);
    });

    // Initialize Pristine validation for the form
    $(".validate-form").each(function () {
        const pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        // Add custom validator for matching passwords
        pristine.addValidator(
            this.querySelector("input[name='confirm-password']"),
            value => value === this.querySelector("input[name='user-password']").value,
            "Passwords do not match"
        );

        // Submit handler
        $(this).on("submit", function (e) {
            e.preventDefault();
            onSubmit(pristine, this);
        });
    });

    // Initialize dropdown visibility on page load
    document.addEventListener('DOMContentLoaded', toggleDropdowns);
})();