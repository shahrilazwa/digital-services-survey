(function () {
    "use strict";

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let roleId = form.querySelector('input[name="role-id"]').value;
            let formData = {
                id: form.querySelector('input[name="role-id"]').value,
                name: form.querySelector('input[name="role-name"]').value,
            };

            axios.put(`/roles/${roleId}`, formData)
            .then(function (response) {
                if (response.status === 200 || response.status === 201) {
                    console.log(response.data.message);
                    window.location.href = '/roles';
                }
            })
            .catch(function (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;

                    if (errors.name) {
                        console.error('Role Name error:', errors.name[0]);
                    }
                } else {
                    console.error('An error occurred:', error.response ? error.response.data : error.message);
                }
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