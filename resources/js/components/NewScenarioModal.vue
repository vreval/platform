<template>
    <modal
        :classes="['modal']"
        :max-width="960"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
        name="new-scenario"
    >
        <h1 class="font-normal text-2xl mb-8">
            Create a new Scenario
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div class="flex-1 ml-4">
                    <h3 class="input-label">Checkpoints</h3>
                    <div
                        v-for="(checkpoint, index) in form.checkpoints"
                        :key="index"
                        class="flex"
                    >
                        <ProjectCheckpointAutosuggest
                            v-model="form.checkpoints[index]"
                            :checkpoints="project.checkpoints"
                            class="mb-2"
                        ></ProjectCheckpointAutosuggest>
                        <button class="block ml-1 p-2 text-gray-600 hover:text-gray-800 focus:outline-none"
                                type="button"
                                @click="removeMember(index)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="btn btn-green-outline text-xs" type="button" @click="addMember">
                        <i class="fas fa-plus mr-1"></i> Add checkpoint
                    </button>
                </div>
            </div>
        </form>

        <modal-footer
            @submit-clicked="submit"
            @cancel-clicked="cancel"
            submit-text="Create Scenario"
        ></modal-footer>
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
            this.form.checkpoints.push({email: ""});
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

