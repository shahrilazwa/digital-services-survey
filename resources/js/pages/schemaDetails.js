document.addEventListener('DOMContentLoaded', () => {
    const viewButtons = document.querySelectorAll('.view-schema');
    const slideOverTitle = document.getElementById('schema-title');
    const slideOverDescription = document.getElementById('schema-description');

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

            const schemaId = button.getAttribute('data-schema-id');
            console.log(schemaId)
            // Fetch schema details
            try {
                const response = await axios.get(`/schemas/${schemaId}`);
                const schema = response.data;
                console.log(schema)
                // Populate slide-over with survey details
                slideOverTitle.textContent = schema.title || 'No Title Available';
                slideOverDescription.innerHTML = `
                    <div class="dark:bg-darkmode-600">
                        <div class="py-2 font-normal space-y-1 border-b text-slate-600 dark:text-slate-500">
                            <p><strong>Status:</strong> <span class="${schema.status === 'Active' ? 'text-success' : 'text-danger'}">${schema.status}</span></p>
                            <p><strong>Create Date:</strong> ${formatDate(schema.created_at)}</p>
                            <p><strong>Modified Date:</strong> ${formatDate(schema.updated_at)}</p>
                        </div>
                        <div class="border-b py-2">
                            <h3 class="block text-base font-medium pb-2 dark:text-gray-300">Team Details</h3>
                            <p><strong>Team Name:</strong> ${schema.team_name || 'N/A'}</p>
                            <p><strong>Team Members:</strong> ${schema.team_members.length > 0 ? schema.team_members.join(', ') : 'N/A'}</p>
                        </div>
                    </div>
                `;
            
                // Open the slide-over
                const slideOver = document.querySelector('#slide-over-details');
                slideOver.classList.add('open');
            } catch (error) {
                console.error('Error fetching schema details:', error);
                alert('Failed to load schema details. Please try again.');
            }
        });
    });
});