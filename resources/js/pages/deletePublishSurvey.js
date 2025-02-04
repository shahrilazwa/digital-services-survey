(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".delete-survey");
    
        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                const surveyId = this.dataset.id;
                const surveyTitle = this.dataset.title;
    
                if (confirm(`Are you sure you want to delete the survey "${surveyTitle}"?`)) {
                    axios.delete(`/publish-surveys/${surveyId}`)
                        .then(response => {
                            if (response.data.success) {
                                alert(response.data.message);
                                location.reload(); // Reload the page to refresh the list
                            }
                        })
                        .catch(error => {
                            console.error("An error occurred:", error);
                            alert("Failed to delete the survey. Please try again.");
                        });
                }
            });
        });
    });
    
})();