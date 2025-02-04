(function () {
    "use strict";

    // Utility function to get form input value
    const getInputValue = (form, selector) => form.querySelector(selector)?.value || null;

    // Handle the form submission for updating the team name and description
    function onUpdateTeamSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const surveySchemaId = document.querySelector('meta[name="survey-schema-id"]').content;

        const formData = {
            team_name: getInputValue(form, 'input[name="team-name"]'),
            team_desc: getInputValue(form, 'textarea[name="team-desc"]'),
        };

        axios.post(`/schemas/${surveySchemaId}/team/update`, formData)
            .then(response => {
                if (response.data.success) {
                    alert('Team details updated successfully!');
                    document.getElementById('teamname').value = response.data.team_name;
                    document.getElementById('team-desc').value = response.data.team_description;
                }
            })
            .catch(error => {
                console.error('Error updating team details:', error);
                alert('Failed to update team details. Please try again.');
            });
    }

    document.addEventListener("DOMContentLoaded", () => {
        const updateForm = document.querySelector(".validate-form");
        if (updateForm) {
            updateForm.addEventListener("submit", onUpdateTeamSubmit);
        }
    });
})();