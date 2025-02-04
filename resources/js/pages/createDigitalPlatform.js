(function () {
    "use strict";

    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;     

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                name: getInputValue(form, 'input[name="platform-name"]'),
                abbr: getInputValue(form, 'input[name="platform-abbr"]'),
                url: getInputValue(form, 'input[name="platform-url"]'),
                type: getInputValue(form, 'select[name="platformTypes[]"]'),
                desc: getInputValue(form, 'textarea[name="platform-desc"]'),
                cluster: getInputValue(form, 'select[name="eaClusters[]"]'),
                owner: document.getElementById('ownerAgency').checked ? 'agency' : 'organization',
                agency: document.getElementById('ownerAgency').checked ? form.querySelector('select[name="agency"]').value : null,
                organization: document.getElementById('ownerOrg').checked ? form.querySelector('select[name="organization"]').value : null,
                digitalServices: Array.from(form.querySelectorAll('select[name="digitalServices[]"] option:checked')).map(option => option.value),
            };

            console.log("Submitting Data:", formData);
            axios.post('/digital-platforms', formData)
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
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.message);
            sessionStorage.setItem('message', response.data.message);
            sessionStorage.setItem('details', response.data.details);
            window.location.href = '/digital-platforms';
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
        const agencyDropdown = $('#agencyDropdown');
        const orgDropdown = $('#orgDropdown');
        
        if ($('#ownerAgency').is(':checked')) {
            agencyDropdown.removeClass('hidden');
            orgDropdown.addClass('hidden');
            $('#orgDropdown select').val(''); 
        } else if ($('#ownerOrg').is(':checked')) {
            orgDropdown.removeClass('hidden');
            agencyDropdown.addClass('hidden');
            $('#agencyDropdown select').val('');
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

    // Attach event listeners to radio buttons
    $('#ownerAgency').on('click', toggleDropdowns);
    $('#ownerOrg').on('click', toggleDropdowns);

})();