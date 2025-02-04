<script setup lang="ts">
import 'survey-core/defaultV2.min.css';
import { Model, SurveyModel } from 'survey-core';
import { SurveyComponent } from 'survey-vue3-ui';
import { ref, watch } from 'vue';

const props = defineProps({
  schemaData: {
    type: Object,
    required: true,
  },
});

// Properly type `survey` as SurveyModel
const survey = ref<SurveyModel | null>(null);

// Watch for changes in schemaData and update the survey model
watch(
  () => props.schemaData,
  (newData) => {
    if (newData) {
      survey.value = new Model(newData) as SurveyModel;

      // Add the onComplete event handler
      survey.value.onComplete.add((sender) => {
        const resultsDiv = document.getElementById("schema-results");
        if (resultsDiv) {
          resultsDiv.innerHTML = `<pre>${JSON.stringify(sender.data, null, 2)}</pre>`;
        }
      });
    }
  },
  { immediate: true }
);
</script>

<template>
  <SurveyComponent v-if="survey" :model="survey" />
</template>