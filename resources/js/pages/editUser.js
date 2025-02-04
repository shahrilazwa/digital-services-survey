(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;    

    function onSubmit(pristine, form) {
        let valid = pristine.validate();
        if (valid) {
            // Prepare form data for AJAX submission
            let placement = form.querySelector('input[name="placement"]:checked')?.value;
            let userId = getInputValue(form, 'input[name="user-id"]');
            let formData = {
                name: getInputValue(form, 'input[name="user-name"]'),
                email: getInputValue(form, 'input[name="user-email"]'),
                personal_email: getInputValue(form, 'input[name="personal-email"]'),
                user_type: getInputValue(form, 'select[name="userTypes[]"]'),
                placement: placement,
                org_id: placement === "organization" ? getInputValue(form, 'select[name="organization"]') : null,
                agency_id: placement === "agency" ? getInputValue(form, 'select[name="agency"]') : null,
                roles: Array.from(form.querySelectorAll('select[name="roles[]"] option:checked')).map(option => option.value),
            };

            axios.put(`/users/${userId}`, formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            window.location.href = '/users';
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
    function toggleDropdowns() {

        const agencyDropdown = $('#agcyDropdown');
        const orgDropdown = $('#orgDropdown');
        const placement = document.querySelector('input[name="placement"]:checked')?.value;
    
        // Show or hide dropdowns based on placement
        if (placement === 'organization') {
            orgDropdown.removeClass('hidden');
            agencyDropdown.addClass('hidden');
            $('#agcyDropdown select').val('');
        } else if (placement === 'agency') {
            agencyDropdown.removeClass('hidden');
            orgDropdown.addClass('hidden');
            $('#orgDropdown select').val('');
        } else {
            agencyDropdown.addClass('hidden');
            orgDropdown.addClass('hidden');
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
    
    // Initialize dropdown state on page load
    document.addEventListener('DOMContentLoaded', toggleDropdowns);
    $('input[name="placement"]').on('click', toggleDropdowns);    

})();
