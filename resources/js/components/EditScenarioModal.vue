<template>
    <modal
        v-if="!loading"
        :classes="['modal']"
        :max-width="960"
        :name="`edit-scenario-${scenario.id}`"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
    >
        <h1 class="font-normal text-2xl mb-8">
            Edit Scenario
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div class="flex-1 ml-4">
                    <h3 class="input-label">Checkpoints</h3>
                    <ProjectCheckpointAutosuggest
                        v-for="(checkpoint, index) in form.checkpoints"
                        :key="index"
                        v-model="form.checkpoints[index]"
                        :checkpoints="checkpoints"
                        :initial-query="form.checkpoints[index].name"
                        class="mb-2"
                    ></ProjectCheckpointAutosuggest>
                    <button class="btn btn-green-outline text-xs" type="button" @click="addMember">
                        <i class="fas fa-plus"></i> Add Checkpoint
                    </button>
                </div>
            </div>
        </form>

        <modal-footer
            submit-text="Update Project"
            @submit-clicked="submit"
            @cancel-clicked="cancel"
        >
            <button class="btn btn-gray-text text-red-600" type="button" @click="removeScenario">Delete</button>
        </modal-footer>
    </modal>
</template>

<script>
import ProjectCheckpointAutosuggest from "./ProjectCheckpointAutosuggest";
import Form from "./VrevalForm";
import BasicFormFields from "./BasicFormFields";
import axios from "axios";

export default {
    name: "EditScenarioModal",
    components: {
        BasicFormFields,
        ProjectCheckpointAutosuggest
    },
    props: {
        scenario: {
            type: Object,
            required: true
        },
    },
    mounted() {
        axios
            .get(`/projects/${this.scenario.project_id}/checkpoints`)
            .then(response => {
                this.checkpoints = response.data.checkpoints;
                this.loading = false;
            })
            .catch(error => console.log(error));

    },
    data() {
        return {
            loading: true,
            checkpoints: [],
            form: new Form({
                name: this.scenario.name,
                description: this.scenario.description,
                checkpoints: this.scenario.checkpoints
            })
        };
    },
    methods: {
        addMember() {
            this.form.checkpoints.push({email: ""});
        },
        removeMember(index) {
            this.form.checkpoints.splice(index, 1);
        },
        submit() {
            this.form.checkpoints = this.form.checkpoints.filter(checkpoint => checkpoint.hasOwnProperty('id'));

            this.form
                .patch(`/projects/${this.scenario.project_id}/scenarios/${this.scenario.id}`)
                .then(response => (location = response.data.message));
        },
        removeScenario() {
            axios.delete(`/projects/${this.scenario.project_id}/scenarios/${this.scenario.id}`)
        },
        cancel() {
            this.form.reset();
            this.$modal.hide(`edit-scenario-${this.scenario.id}`);
        }
    }
}
</script>
