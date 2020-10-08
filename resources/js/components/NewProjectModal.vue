<template>
    <modal name="new-project" classes="modal" height="auto">
        <h1 class="font-normal text-2xl mb-8 text-center">
            Create a new Project
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <h3 class="input-label">Invite some members</h3>
                        <div
                            class="flex mb-2"
                            v-for="(member, index) in form.members"
                            :key="index"
                        >
                            <project-user-autosuggest v-model="form.members[index]"></project-user-autosuggest>
                            <button type="button" @click="removeMember(index)">
                                x
                            </button>
                        </div>
                        <button type="button" class="btn btn-green text-xs" @click="addMember">
                            (+) Add member
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <footer class="flex justify-between">
            <button
                type="button"
                class="btn btn-gray mr-2"
                @click="$modal.hide('new-project')"
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
import Form from "./VrevalForm";
import BasicFormFields from "./BasicFormFields";
import ProjectUserAutosuggest from "./ProjectUserAutosuggest";

export default {
    name: "NewProjectModal",
    components: {ProjectUserAutosuggest, BasicFormFields },
    data() {
        return {
            form: new Form({
                name: "",
                description: "",
                members: [{ email: "" }]
            })
        };
    },
    methods: {
        addMember() {
            this.form.members.push({ email: "" });
        },
        removeMember(index) {
            this.form.members.splice(index, 1);
        },
        submit() {
            // Remove empty or invalid fields
            this.form.members = this.form.members.filter(member => member.hasOwnProperty('id'));

            this.form
                .submit("/projects")
                .then(response => (location = response.data.message));
        }
    }
};
</script>
