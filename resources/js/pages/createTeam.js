(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    function onSubmit(form) {
        if (validateForm(form)) {
            const formData = {
                user_id: getInputValue(form, 'select[name="add-user"]'),
                role: getInputValue(form, 'select[name="roles[]"]'),
                // start_date: getInputValue(form, 'input[name="start_date"]') || new Date().toISOString().split('T')[0],
            };

            // Get the Survey Schema ID from the meta tag
            const surveySchemaId = document.querySelector('meta[name="survey-schema-id"]').content;

            axios
                .post(`/schemas/${surveySchemaId}/team/add`, formData)
                .then(response => handleSuccess(response))
                .catch(error => handleError(error));
        }
    }

    // Success handler
    function handleSuccess(response) {
        if (response.status === 200 || response.status === 201) {
            console.log(response.data.message);
            // Reload the page to display the updated team member list
            window.location.reload();
        } else {
            console.error("Unexpected response:", response);
            alert("Unexpected response from the server. Please try again.");
        }
    }

    // Error handler
    function handleError(error) {
        if (error.response && error.response.status === 422) {
            console.log("Validation Errors:", error.response.data.errors);
            alert("Validation Error: " + JSON.stringify(error.response.data.errors));
        } else {
            console.error("An error occurred:", error.response?.data || error.message);
            alert("Error: " + (error.response?.data.message || error.message));
        }
    }

    // Validate the form inputs
    function validateForm(form) {
        const userId = getInputValue(form, 'select[name="add-user"]');
        const role = getInputValue(form, 'select[name="roles[]"]');

        if (!userId) {
            alert("Please select a user.");
            return false;
        }

        if (!role) {
            alert("Please select a role.");
            return false;
        }

        return true;
    }

    function onRemoveClick(event) {
        const userId = this.getAttribute("data-user-id");
        const surveySchemaId = document.querySelector('meta[name="survey-schema-id"]').content;

        if (confirm("Are you sure you want to remove this team member?")) {
            axios
                .delete(`/schemas/${surveySchemaId}/team/remove`, {
                    data: { user_id: userId },
                })
                .then(response => handleRemoveSuccess({ ...response, user_id: userId }))
                .catch(handleRemoveError);
        }
    }

    // Success handler
    function handleRemoveSuccess(response) {
        if (response.status === 200) {
            console.log(response.data.message);
            // Remove the team member row from the DOM
            const memberRow = document.querySelector(`#member-row-${response.data.user_id}`);
            if (memberRow) memberRow.remove();
        } else {
            console.error("Unexpected response:", response);
            alert("Unexpected response from the server. Please try again.");
        }
    }

    // Error handler
    function handleRemoveError(error) {
        if (error.response && error.response.status === 422) {
            console.log("Validation Errors:", error.response.data.errors);
            alert("Validation Error: " + JSON.stringify(error.response.data.errors));
        } else {
            console.error("An error occurred:", error.response?.data || error.message);
            alert("Error: " + (error.response?.data.message || error.message));
        }
    }    

    // Attach the event listener to the form
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("#team-member-form");
        const removeButtons = document.querySelectorAll(".remove-button");

        removeButtons.forEach(button => {
            button.addEventListener("click", onRemoveClick);
        });        

        if (form) {
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                onSubmit(form);
            });
        }
    });
})();
