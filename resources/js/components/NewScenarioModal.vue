<template>
    <modal name="new-scenario" height="auto" classes="modal">
        <h1 class="font-normal text-2xl mb-8 text-center">
            Create a new Scenario
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
            <button type="button" class="btn btn-green" @click="submit">
                Create Project
            </button>
        </footer>
    </modal>
</template>

<script>
import ProjectCheckpointAutosuggest from "./ProjectCheckpointAutosuggest";
import Form from "./VrevalForm";
import BasicFormFields from "./BasicFormFields";

export default {
    name: "NewScenarioModal",
    components: {
        BasicFormFields,
        ProjectCheckpointAutosuggest
    },
    props: {
        project: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: new Form({
                name: "",
                description: "",
                checkpoints: []
            })
        };
    },
    methods: {
        addMember() {
            this.form.checkpoints.push({ email: "" });
        },
        removeMember(index) {
            this.form.checkpoints.splice(index, 1);
        },
        submit() {
            this.form.checkpoints = this.form.checkpoints.filter(checkpoint => checkpoint.hasOwnProperty('id'));

            this.form
                .submit(`/projects/${this.project.id}/scenarios`)
                .then(response => (location = response.data.message));
        },
        cancel() {
            this.form.reset();
            this.$modal.hide('new-scenario');
        }
    }
}
</script>

