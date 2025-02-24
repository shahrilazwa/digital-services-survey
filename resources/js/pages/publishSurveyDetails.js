document.addEventListener('DOMContentLoaded', () => {
    const viewButtons = document.querySelectorAll('.view-survey');
    const slideOverTitle = document.getElementById('survey-title');
    const slideOverDescription = document.getElementById('survey-description');

    // Utility function to format date to dd/mm/yyyy
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        if (isNaN(date)) return 'Invalid Date';
        return date.toLocaleDateString('en-GB'); // 'en-GB' formats as dd/mm/yyyy
    }

    viewButtons.forEach((button) => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();

            const surveyId = button.getAttribute('data-survey-id');
            console.log(`Survey Id: ${surveyId}`);
            // Fetch survey details
            try {
                const response = await axios.get(`/publish-surveys/${surveyId}`);
                const survey = response.data;
                console.log('Response data:', response.data);
                // Populate slide-over with survey details
                slideOverTitle.textContent = survey.title || 'No Title Available';
                slideOverDescription.innerHTML = `
                    <div class="dark:bg-darkmode-600">
                        <div class="border-b pb-2">
                            <h3 class="block text-base font-medium">Survey Details</h3>
                        </div>
                        <div class="py-2 font-normal space-y-1 border-b text-slate-600 dark:text-slate-500">
                            <p><strong>Status:</strong> <span class="${survey.status === 'Active' ? 'text-success' : 'text-danger'}">${survey.status}</span></p>
                            <p><strong>Survey Link:</strong> <a href="${survey.survey_link || '#'}" target="_blank" class="text-blue-600 hover:underline">${survey.survey_link || 'N/A'}</a></p>
                            <p><strong>Start Date:</strong> ${formatDate(survey.start_date)}</p>
                            <p><strong>End Date:</strong> ${formatDate(survey.end_date)}</p>
                        </div>
                        <div class="border-b py-2">
                            <h3 class="block text-base font-medium pb-2 dark:text-gray-300">Survey Schema</h3>
                            <p>${survey.survey_schema || 'N/A'}</p>
                        </div>
                        <div class="border-b py-2">
                            <h3 class="block text-base font-medium pb-2 dark:text-gray-300">Team Details</h3>
                            <p><strong>Team Name:</strong> ${survey.team_name || 'N/A'}</p>
                            <p><strong>Team Members:</strong> ${survey.team_members.length > 0 ? survey.team_members.join(', ') : 'N/A'}</p>
                        </div>
                        <div class="border-b py-2">
                            <h3 class="block text-base font-medium pb-2 dark:text-gray-300"">Digital Platform</h3>
                            <p>${survey.digital_platform || 'N/A'}</p>
                        </div>
                        <div class="border-b py-2">
                            <h3 class="block text-base font-medium pb-2 dark:text-gray-300">Digital Service</h3>
                            <p>${survey.service || 'N/A'}</p>
                        </div>
                    </div>
                `;
            
                // Open the slide-over
                const slideOver = document.querySelector('#slide-over-details');
                slideOver.classList.add('open');
            } catch (error) {
                console.error('Error fetching survey details:', error);
                alert('Failed to load survey details. Please try again.');
            }
        });
    });
});