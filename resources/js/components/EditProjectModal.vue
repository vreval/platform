<template>
    <modal name="edit-project" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal text-2xl mb-8 text-center">
            Edit Project
        </h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="name" class="input-label">Name</label>
                        <input
                            type="text"
                            id="name"
                            class="input"
                            :class="
                                form.errors.name ? 'border border-red-600' : ''
                            "
                            v-model="form.name"
                        />
                        <div v-if="form.errors">
                            <span
                                class="text-red-400 text-xs italic"
                                v-for="(error, index) in form.errors.name"
                                :key="index"
                                >{{ error }}</span
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="input-label"
                            >Description</label
                        >
                        <textarea
                            id="description"
                            class="input"
                            :class="
                                form.errors.description
                                    ? 'border border-red-600'
                                    : ''
                            "
                            rows="5"
                            v-model="form.description"
                        ></textarea>
                        <div v-if="form.errors">
                            <span
                                class="text-red-400 text-xs italic"
                                v-for="(error, index) in form.errors
                                    .description"
                                :key="index"
                                >{{ error }}</span
                            >
                        </div>
                    </div>
                </div>
                <div class="flex-1 ml-4" v-if="canAdminister">
                    <div class="mb-4">
                        <label class="input-label">Manage Members</label>
                        <div
                            class="flex mb-2"
                            v-for="(member, index) in form.members"
                            :key="index"
                        >
                            <user-search
                                v-model="form.members[index]"
                            ></user-search>
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
                @click="$modal.hide('edit-project')"
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
export default {
    name: "EditProjectModal",
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
        }
    }
};
</script>
