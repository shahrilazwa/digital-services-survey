(function () {
    "use strict";

    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(pristine, form, redirectUrl, step) {
        if (pristine.validate()) {
            const schemaId = form.querySelector('input[name="schema-id"]').value;
            const formData = {
                title: getInputValue(form, 'input[name="schema-title"]'),
                description: getInputValue(form, 'textarea[name="schema-desc"]'),
                current_step: step,
            };
            axios
                .put(`/schemas/${schemaId}`, formData)
                .then(() => {
                    window.location.href = redirectUrl;
                })
                .catch(error => handleError(error));
        } else {
            Toastify({
                text: "Validation failed",
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
        }
    }

    function handleError(error) {
        console.error(error.response?.data || error.message);
    }

    $(".validate-form").each(function () {
        const pristine = new Pristine(this, {
            classTo: "input-form",
            errorClass: "has-error",
            errorTextParent: "input-form",
            errorTextClass: "text-danger mt-2",
        });

        $(this).on("submit", function (e) {
            e.preventDefault();
            const step = $(this).find("button[type='submit']").data("step");
            const redirectUrl = $(this).find("button[type='submit']").data("redirect");
            onSubmit(pristine, this, redirectUrl, step);
        });

        $("[name^='btn-schema-']").on("click", function (e) {
            e.preventDefault();
            const form = $(".validate-form")[0];
            const step = $(this).data("step");
            const redirectUrl = $(this).data("redirect");
            onSubmit(pristine, form, redirectUrl, step);
        });
    });
})();