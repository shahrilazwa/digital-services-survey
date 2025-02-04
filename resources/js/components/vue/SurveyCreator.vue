<script setup>
import { SurveyCreatorModel } from "survey-creator-core";
import { SurveyCreatorComponent } from "survey-creator-vue";

import "survey-core/survey.i18n.js";
import "survey-creator-core/survey-creator-core.i18n.js";
import "survey-core/defaultV2.min.css";
import "survey-creator-core/survey-creator-core.min.css";

// Access surveySchema from global AppData object
const surveySchema = window.AppData?.surveySchema;

// Options for Survey Creator
const creatorOptions = {
  showLogicTab: true,
  isAutoSave: false,
  showTranslationTab: true,
  showJSONEditorTab: true,
  showThemeTab: true, // Enable Theme Editor tab
};

const creator = new SurveyCreatorModel(creatorOptions);

// Initialize SurveyCreatorModel with JSON data from surveySchema
if (surveySchema && surveySchema.schema_json) {
  try {
    creator.JSON = JSON.parse(surveySchema.schema_json);
  } catch (error) {
    console.error("Error parsing initial survey data:", error);
  }
}

// Handle active tab changes
creator.onActiveTabChanged.add((sender) => {
  const activeTab = sender.activeTab;

  console.log(`Switched to tab: ${activeTab}`);

  if (activeTab === "theme") {
    console.log("Theme Editor tab activated.");
    // Example of applying a custom theme (this updates the JSON theme directly)
    creator.themeEditor.applyTheme({
      "--background-color": "#f9f9f9",
      "--main-color": "#4caf50",
      "--text-color": "#333",
      "--header-color": "#3e8e41",
    });
  }

  if (activeTab === "test") {
    console.log("Preview tab activated.");
    console.log("Current survey JSON for preview:", creator.JSON);
  }
});

// Function to save survey data via Axios
creator.saveSurveyFunc = async (saveNo, callback) => {
  if (!surveySchema) {
    alert("Survey schema is not defined.");
    return;
  }

  try {
    const payload = {
      schema_data: JSON.stringify(creator.JSON),
      save_num: saveNo,
    };
    console.log("Saving survey data: ", payload);

    const response = await axios.post(`/schemas/${surveySchema.id}/design`, payload);

    if (response.data && response.data.message) {
      alert("Schema saved successfully!");
      callback(saveNo, true);
    } else {
      alert("Unexpected response from server");
      callback(saveNo, false);
    }
  } catch (error) {
    alert("Error saving survey: " + (error.message || "Unknown error"));
    callback(saveNo, false);
  }
};
</script>

<template>
  <SurveyCreatorComponent :model="creator" />
</template>