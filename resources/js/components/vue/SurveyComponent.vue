<script setup lang="ts">
import 'survey-core/defaultV2.min.css';
import { Model, SurveyModel } from 'survey-core';
import { SurveyComponent } from 'survey-vue3-ui';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import dayjs from 'dayjs';

// Define props
const props = defineProps({
    surveyData: {
        type: Object,
        required: true,
    },
});

const survey = ref<SurveyModel | null>(null);

onMounted(() => {
    console.log("Survey Component mounted.");

    // Ensure surveyData is valid
    if (props.surveyData && Object.keys(props.surveyData).length > 0) {
        survey.value = new Model(props.surveyData); // Initialize SurveyModel
        console.log("Survey model initialized.");

        // Attach the onComplete event
        survey.value.onComplete.add((sender) => {
            console.log("Survey completed. Results:", sender.data);

            axios.post(`/survey-results/${props.surveyData.id}`, {
                published_survey_id: props.surveyData.id,
                response_json: JSON.stringify(sender.data),
                submitted_at: dayjs().format('YYYY-MM-DD HH:mm:ss'),
            })
            .then((response) => {
                console.log("Survey results saved successfully:", response.data);
                alert("Thank you! Your survey response has been submitted.");
            })
            .catch((error) => {
                console.error("Error saving survey results:", error);
                alert("There was an error submitting the survey. Please try again later.");
            });
        });
    } else {
        console.error("Survey data is missing or invalid.");
    }
});
</script>

<template>
    <div>
        <SurveyComponent v-if="survey" :model="survey" />
        <div v-else>
            <p>Error loading survey.</p>
        </div>
    </div>
</template>