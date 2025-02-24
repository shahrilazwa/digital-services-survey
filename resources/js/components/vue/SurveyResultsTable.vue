<template>
    <div class="table-container">
        <div id="surveyDataTable"></div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import "tabulator-tables/dist/css/tabulator.min.css";
import "survey-analytics/survey.analytics.tabulator.min.css";
import { Model } from "survey-core";
import { Tabulator } from "survey-analytics/survey.analytics.tabulator";

export default {
    setup() {
        const surveyDataTable = ref(null);

        onMounted(() => {
            const appElement = document.getElementById("survey-results-app");

            if (!appElement) {
                console.error("survey-results-app not found in the DOM");
                return;
            }

            // ✅ Load schema and results from Blade template
            const surveySchema = JSON.parse(appElement.dataset.surveySchema || "{}");
            const surveyResults = JSON.parse(appElement.dataset.surveyResults || "[]");

            console.log("Survey Schema Loaded:", surveySchema);
            console.log("Survey Data Loaded:", surveyResults);

            if (surveyResults.length && Object.keys(surveySchema).length) {
                try {
                    // ✅ Create SurveyJS Model
                    const survey = new Model(surveySchema);
                    console.log("Survey Model Created:", survey);

                    // ✅ Initialize SurveyJS Tabulator with pagination & toolbar
                    const tableInstance = new Tabulator(survey, surveyResults, {
                        allowDownload: true, // ✅ Enables CSV Export
                        allowHideColumns: true, // ✅ Column visibility toggle
                        showToolbar: true, // ✅ Show Toolbar with CSV Export & Search
                        allowSorting: true, // ✅ Enable sorting
                        allowFilters: true, // ✅ Enable column filters
                        tabulatorOptions: {
                            pagination: "local", // ✅ Enable pagination
                            paginationSize: 10, // ✅ Fixed 10 rows per page
                            paginationSizeSelector: false, // ✅ Hide page size dropdown
                            layout: "fitColumns", // ✅ Auto-adjust columns
                            movableColumns: true, // ✅ Allow column reordering
                            resizableColumns: true, // ✅ Allow column resizing
                            initialSort: [{ column: "question1", dir: "asc" }], // ✅ Example sorting
                        },
                    });

                    console.log("Tabulator Created:", tableInstance);
                    tableInstance.render("surveyDataTable");

                } catch (error) {
                    console.error("Error initializing SurveyJS Table:", error);
                }
            }
        });

        return { surveyDataTable };
    },
};
</script>

<style scoped>
/* ✅ Ensure proper table scrolling */
.table-container {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 10px;
}

/* ✅ Prevent shrinking, force full width */
#surveyDataTable {
    min-width: 100%;
    width: max-content;
    border: 1px solid #ccc;
}
</style>
