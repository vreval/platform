<template>
    <modal name="new-project" classes="modal" height="auto">
        <h1 class="font-normal text-2xl mb-8 text-center">
            Create a new Project
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
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <h3 class="input-label">Invite some members</h3>
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
export default {
    name: "NewProjectModal",
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
            if (!this.form.members[0].email) {
                delete this.form.originalData.members;
            }

            this.form
                .submit("/projects")
                .then(response => (location = response.data.message));
        }
    }
};
</script>
