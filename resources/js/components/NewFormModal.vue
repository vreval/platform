<template>
    <modal
        :classes="['modal']"
        :max-width="960"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
        name="new-form"
    >
        <h1 class="font-normal text-2xl mb-8">
            Create a new Form
        </h1>
        <form @submit.prevent="submit">
            <basic-form-fields v-model="form"></basic-form-fields>
        </form>

        <modal-footer
            @submit-clicked="submit"
            @cancel-clicked="cancel"
            submit-text="Create Form"
        ></modal-footer>
    </modal>
</template>

<script>
import Form from "./VrevalForm";
import BasicFormFields from "./BasicFormFields";

export default {
    name: "NewScenarioModal",
    components: {
        BasicFormFields,
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
        submit() {
            this.form
                .submit(`/projects/${this.project.id}/forms`)
                .then(response => (location = response.data.message));
        },
        cancel() {
            this.form.reset();
            this.$modal.hide('new-form');
        }
    }
}
</script>

