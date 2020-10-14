<template>
    <modal
        :classes="['modal']"
        :max-width="960"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
        name="edit-project"
    >
        <h1 class="font-normal text-2xl mb-8 text-center">
            Edit Project
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div v-if="canAdminister" class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="input-label">Manage Members</label>
                        <div
                            v-for="(member, index) in form.members"
                            :key="index"
                            class="flex mb-2"
                        >
                            <project-user-autosuggest v-model="form.members[index]"
                                                      :initial-query="member.name"></project-user-autosuggest>
                            <button type="button" @click="removeMember(index)">
                                <i class="fas fa-times text-gray-600"></i>
                            </button>
                        </div>
                        <button class="block btn btn-green-outline text-xs" type="button" @click="addMember">
                            <i class="fas fa-plus"></i> Add member
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <footer class="flex justify-between">
            <div>
                <button class="btn btn-green" type="button" @click="submit">
                    Update Project
                </button>
                <button
                    class="btn btn-gray-text ml-2"
                    type="button"
                    @click="cancel"
                >
                    Cancel
                </button>
            </div>
            <button class="btn btn-gray-text text-red-600" type="button" @click="removeProject">Delete</button>
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
        },
        removeProject() {
            this.form
                .delete(`/projects/${this.project.id}`)
                .then(response => (location = response.data.message));
        }
    }
};
</script>
