<template>
    <div>
        <div @click="$modal.show(`edit-scenario-${scenario.id}`)" class="cursor-pointer">
            <slot></slot>
        </div>
        <modal :name="`edit-scenario-${scenario.id}`" height="auto" classes="modal">
            <h1 class="font-normal text-2xl mb-8 text-center">
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
                            :checkpoints="project.checkpoints"
                            v-model="form.checkpoints[index]"
                            class="mb-2"
                            :initial-query="form.checkpoints[index].name"
                        ></ProjectCheckpointAutosuggest>
                        <button type="button" class="btn" @click="addMember">
                            (+) Add checkpoint
                        </button>
                    </div>
                </div>
            </form>

            <footer class="flex justify-between">
                <button
                    type="button"
                    class="btn btn-gray mr-2"
                    @click="cancel"
                >
                    Cancel
                </button>
                <div>
                    <button type="button" class="btn btn-red-outline" @click="removeScenario">Delete</button>
                    <button type="button" class="btn btn-green" @click="submit">
                        Update Scenario
                    </button>
                </div>
            </footer>
        </modal>
    </div>
</template>

<script>
import ProjectCheckpointAutosuggest from "./ProjectCheckpointAutosuggest";
import Form from "./VrevalForm";
import BasicFormFields from "./BasicFormFields";

export default {
    name: "EditScenarioModal",
    components: {
        BasicFormFields,
        ProjectCheckpointAutosuggest
    },
    props: {
        project: {
            type: Object,
            required: true
        },
        scenario: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
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
                .patch(`/projects/${this.project.id}/scenarios/${this.scenario.id}`)
                .then(response => (location = response.data.message));
        },
        removeScenario() {
            axios.delete(`/projects/${this.project.id}/scenarios/${this.scenario.id}`)
        },
        cancel() {
            this.form.reset();
            this.$modal.hide(`edit-scenario-${this.scenario.id}`);
        }
    }
}
</script>
