<template>
    <modal
        :shiftY="0.2"
        :classes="['modal']"
        height="auto"
        :width="'90%'"
        :max-width="960"
        name="new-project"
    >
        <h2 class="font-normal text-2xl">Create a new Project</h2>
        <span class="block text-sm font-medium text-gray-600 mb-8"
        >Start with a brand new slate</span
        >
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <basic-form-fields v-model="form"></basic-form-fields>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <h3 class="input-label">
                            Invite people to collaborate
                        </h3>
                        <div
                            v-for="(member, index) in form.members"
                            :key="index"
                            class="flex mb-2"
                        >
                            <project-user-autosuggest
                                v-model="form.members[index]"
                            ></project-user-autosuggest>
                            <button type="button" @click="removeMember(index)" class="block ml-1 p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <button
                            class="btn btn-green-outline text-xs"
                            type="button"
                            @click="addMember"
                        >
                            <i class="fas fa-plus mr-1"></i>Add member
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <footer class="flex">
            <button class="btn btn-green" type="button" @click="submit">
                Create Project
            </button>
            <button
                class="btn btn-gray ml-2"
                type="button"
                @click="$modal.hide('new-project')"
            >
                Cancel
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
    components: {ProjectUserAutosuggest, BasicFormFields},
    data() {
        return {
            form: new Form({
                name: "",
                description: "",
                members: [{email: ""}]
            })
        };
    },
    methods: {
        addMember() {
            this.form.members.push({email: ""});
        },
        removeMember(index) {
            this.form.members.splice(index, 1);
        },
        submit() {
            // Remove empty or invalid fields
            this.form.members = this.form.members.filter(member =>
                member.hasOwnProperty("id")
            );

            this.form
                .submit("/projects")
                .then(response => (location = response.data.message));
        }
    }
};
</script>
