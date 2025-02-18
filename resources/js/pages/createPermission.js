(function () {
    "use strict";
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form) {
        let valid = pristine.validate();

        if (valid) {
            let formData = {
                name: getInputValue(form, 'input[name="perm-name"]'),
                group: getInputValue(form, 'input[name="perm-group"]'),
                description: getInputValue(form, 'textarea[name="perm-desc"]'),
            };

            axios.post('/permissions', formData)
            .then(function (response) {
                if (response.status === 200 || response.status === 201) {
                    console.log(response.data.message);
                    window.location.href = '/permissions';
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
