// Load static files
import.meta.glob(["../images/**"]);
import { createApp } from 'vue';
import SurveyCreator from './components/vue/SurveyCreator.vue';
import SchemaViewer from './components/vue/SchemaViewer.vue';
import SurveyComponent from './components/vue/SurveyComponent.vue';
import SurveyResultsTable from "./components/vue/SurveyResultsTable.vue";
import axios from 'axios';

// Configure Axios with CSRF token
axios.defaults.headers.common['X-CSRF-TOKEN'] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

// Mount SchemaViewer on pages where it exists
const viewerElement = document.getElementById('survey-viewer-app');
if (viewerElement) {
    const viewerApp = createApp({
        components: { SchemaViewer },
    });
    viewerApp.mount('#survey-viewer-app');
}

// Mount SurveyCreator on pages where it exists
const creatorElement = document.getElementById('survey-creator-app');
if (creatorElement) {
    const creatorApp = createApp({
        components: { SurveyCreator },
    });
    creatorApp.mount('#survey-creator-app');
} 

// Mount SurveyComponent on pages where it exists
const surveyFormElement = document.getElementById('survey-form-app');
if (surveyFormElement) {
    const surveyApp = createApp({
        components: { SurveyComponent }, // Register SurveyComponent
    });

    surveyApp.component('SurveyComponent', SurveyComponent); // Register globally if needed
    surveyApp.mount('#survey-form-app');
    console.log("Vue app mounted successfully.");
}

// Mount SurveyResultsTable if element exists
const surveyResultsElement = document.getElementById("survey-results-app");
if (surveyResultsElement) {
  createApp(SurveyResultsTable).mount("#survey-results-app");
}