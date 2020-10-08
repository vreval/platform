<template>
    <modal name="edit-project" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal text-2xl mb-8 text-center">
            Edit Project
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div class="flex-1 ml-4" v-if="canAdminister">
                    <div class="mb-4">
                        <label class="input-label">Manage Members</label>
                        <div
                            class="flex mb-2"
                            v-for="(member, index) in form.members"
                            :key="index"
                        >
                            <project-user-autosuggest v-model="form.members[index]" :initial-query="member.name"></project-user-autosuggest>
                            <button type="button" @click="removeMember(index)">
                                x
                            </button>
                        </div>
                        <button type="button" class="btn" @click="addMember">
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
                @click="cancel"
            >
                Cancel
            </button>
            <button type="button" class="btn btn-green" @click="submit">
                Update Project
            </button>
        </footer>
    </modal>
</template>

<script>
import Form from "./VrevalForm";
import ProjectUserAutosuggest from "./ProjectUserAutosuggest";
import BasicFormFields from "./BasicFormFields";
export default {
    name: "EditProjectModal",
    components: {BasicFormFields, ProjectUserAutosuggest},
    props: {
        canAdminister: {
            type: Boolean,
            default: false
        },
        project: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: new Form({
                name: this.project.name,
                description: this.project.description,
                members: this.project.members.map(member => ({
                    id: member.id,
                    name: member.name,
                    email: member.email
                }))
            })
        };
    },
    methods: {
        addMember() {
            this.form.members.push({});
        },
        removeMember(index) {
            this.form.members.splice(index, 1);
        },
        submit() {
            this.form.members = this.form.members.filter(member => member.hasOwnProperty('id'));

            this.form
                .patch(`/projects/${this.project.id}`)
                .then(response => (location = response.data.message));
        },
        cancel() {
            this.form.reset();
            this.$modal.hide('edit-project');
        }
    }
};
</script>
