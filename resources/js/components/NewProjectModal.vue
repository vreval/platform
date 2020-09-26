<template>
    <modal name="new-project" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal text-2xl mb-8 text-center">Create a new Project</h1>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm mb-3">Name</label>
                        <input
                            type="text"
                            id="name"
                            class="border border-gray-400 p-2 text-xs block w-full rounded-lg"
                            :class="form.errors.name ? 'border border-red-600' : ''"
                            v-model="form.name"
                        >
                        <span
                            class="text-red-400 text-xs italic"
                            v-if="form.errors"
                            v-for="(error, index) in form.errors.name"
                            :key="index"
                        >{{ error }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm mb-3">Description</label>
                        <textarea
                            id="description"
                            class="border border-gray-400 p-2 text-xs block w-full rounded-lg"
                            :class="form.errors.description ? 'border border-red-600' : ''"
                            rows="5"
                            v-model="form.description"
                        ></textarea>
                        <span
                            class="text-red-400 text-xs italic"
                            v-if="form.errors"
                            v-for="(error, index) in form.errors.description"
                            :key="index"
                        >{{ error }}</span>
                    </div>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label class="block text-sm mb-3">Invite some members</label>
                        <input
                            type="email"
                            placeholder="Member E-Mail"
                            class="border border-gray-400 p-2 mb-2 text-xs block w-full rounded-lg"
                            v-for="(member, index) in form.members"
                            :key="index"
                            v-model="member.email"
                        >
                        <button type="button" class="btn" @click="addMember">(+) Add member</button>
                    </div>
                </div>
            </div>
        </form>

        <footer>
            <button type="button" class="btn btn-gray mr-2" @click="$modal.hide('new-project')">Cancel</button>
            <button type="button" class="btn btn-green" @click="submit">Create Project</button>
        </footer>
    </modal>
</template>

<script>
import Form from './VrevalForm';
export default {
    name: "NewProjectModal",
    data() {
        return {
            form: new Form({
                name: '',
                description: '',
                members: [
                    { email: '' }
                ]
            })
        }
    },
    methods: {
        addMember() {
            this.form.members.push({email: ''})
        },
        submit() {
            if (!this.form.members[0].email) {
                delete this.form.originalData.members;
            }

            this.form.submit('/projects')
                .then(response => location = response.data.message);
        }
    }
}
</script>
