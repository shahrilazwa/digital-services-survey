(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    const surveySchemaId = document.querySelector('meta[name="survey-schema-id"]').content;

    // Success and error handlers
    function handleSuccess(response, message, redirectUrl = null) {
        alert(message || response.data.message);
        if (redirectUrl) {
            window.location.href = redirectUrl;
        } else {
            window.location.reload();
        }
    }

    function handleError(error, defaultMessage = "An error occurred") {
        const message =
            (error.response && error.response.data.message) || defaultMessage;
        console.error(message, error.response?.data || error.message);
        alert(message);
    }

    // Submit handler for "Add Member"
    function onAddMemberSubmit(event) {
        event.preventDefault();
        const form = event.target;

        const formData = {
            user_id: getInputValue(form, 'select[name="add-user"]'),
            role: getInputValue(form, 'select[name="roles[]"]'),
            current_step: "Schema Team",
        };

        axios
            .post(`/schemas/${surveySchemaId}/team/add`, formData)
            .then(response =>
                handleSuccess(response, "Team member added successfully!")
            )
            .catch(error =>
                handleError(error, "Failed to add team member.")
            );
    }

    // Submit handler for "Update Team Details"
    function onUpdateTeamSubmit(event) {
        event.preventDefault();
        const form = event.target;

        const formData = {
            team_name: getInputValue(form, 'input[name="team-name"]'),
            team_desc: getInputValue(form, 'textarea[name="team-desc"]'),
            current_step: "Schema Team",
        };

        axios
            .post(`/schemas/${surveySchemaId}/team/update`, formData)
            .then(response =>
                handleSuccess(response, "Team details updated successfully!")
            )
            .catch(error =>
                handleError(error, "Failed to update team details.")
            );
    }

    // Remove team member
    function onRemoveMemberClick(event) {
        const userId = event.target.getAttribute("data-user-id");

        if (confirm("Are you sure you want to remove this team member?")) {
            axios
                .delete(`/schemas/${surveySchemaId}/team/remove`, {
                    data: {
                        user_id: userId,
                        current_step: "Schema Team",
                    },
                })
                .then(response => {
                    alert("Team member removed successfully!");
                    document.querySelector(`#member-row-${userId}`)?.remove();
                })
                .catch(error =>
                    handleError(error, "Failed to remove team member.")
                );
        }
    }

    // Handle Wizard Button Click
    function onWizardButtonClick(e) {
        e.preventDefault();
        const button = e.currentTarget;
        const step = button.getAttribute("data-step");
        const redirectUrl = button.getAttribute("data-redirect");

        console.log(redirectUrl);

        if (step) {
            window.location.href = redirectUrl;
            // updateStep(step, redirectUrl);
        }
    }

    // Update Step and Redirect
    function updateStep(step, redirectUrl) {
        axios
            .post(`/schemas/${surveySchemaId}/team/update`, { current_step: step })
            .then(response => {
                console.log(response.data.message);
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            })
            .catch(error => {
                console.error("Failed to update step:", error.response?.data || error.message);
                alert("Error: " + (error.response?.data.message || error.message));
            });
    }    

    // Attach event listeners
    document.addEventListener("DOMContentLoaded", () => {
        // "Add Member" form
        const addMemberForm = document.querySelector("#add-member-form");
        if (addMemberForm) {
            addMemberForm.addEventListener("submit", onAddMemberSubmit);
        }

        // "Update Team Details" form
        const updateTeamForm = document.querySelector(".validate-form");
        if (updateTeamForm) {
            updateTeamForm.addEventListener("submit", onUpdateTeamSubmit);
        }

        // Remove team member buttons
        const removeButtons = document.querySelectorAll(".remove-button");
        removeButtons.forEach(button => {
            button.addEventListener("click", onRemoveMemberClick);
        });

        // Wizard buttons
        const wizardButtons = document.querySelectorAll("[name^='btn-schema-']");
        wizardButtons.forEach(button => {
            button.addEventListener("click", onWizardButtonClick);
        });        
    });
})();