(function () {
    "use strict";
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                id: getInputValue(form, 'input[name="perm-id"]'),
                name: getInputValue(form, 'input[name="perm-name"]'),
                group: getInputValue(form, 'input[name="perm-group"]'),
                description: getInputValue(form, 'textarea[name="perm-desc"]'),
            };

            axios.put(`/permissions/${formData.id}`, formData)
            .then(function (response) {
                if (response.status === 200 || response.status === 201) {
                    console.log(response.data.message);

                    // Use 'success' for updates, 'info' for no changes
                    let messageType = response.data.success ? "success" : "info";
                    console.log(`${window.routes.permissionsIndex}?${messageType}=${encodeURIComponent(response.data.message)}`);
                    window.location.href = `${window.routes.permissionsIndex}?${messageType}=${encodeURIComponent(response.data.message)}`;
                }
            })
            .catch(function (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;

                    if (errors.name) {
                        console.error('Permission Name error:', errors.name[0]);
                    }
                } else {
                    console.error('An error occurred:', error.response ? error.response.data : error.message);
                }
                window.location.href = `${window.routes.permissionsIndex}?error=Failed to update permission '${formData.name}'.`;
            });
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