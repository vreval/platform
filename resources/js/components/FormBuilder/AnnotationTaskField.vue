<template>
    <div class="card mb-4">
        <div class="flex items-center justify-between">
            <h4 class="text-xs font-medium tracking-wider uppercase text-gray-600">Annotation Task</h4>
            <div class="flex">
                <button class="btn btn-icon ml-4" type="button" @click="$emit('remove')"><i
                    class="far fa-trash-alt"></i></button>
            </div>
        </div>
        <textarea v-model="task.description" class="input mb-2" placeholder="Type the task description here..."
                  rows="5"></textarea>
        <div class="mb-2">
            <label class="input-label">Which form should be used by annotations?</label>
            <div v-if="forms.length > 0" class="h-64 border rounded overflow-y-scroll">
                <div v-for="(form, index) in forms" :key="index"
                     class="p-4 border-b hover:bg-gray-200 flex items-center cursor-pointer"
                     @click="selectedForm = index"
                >
                    <i
                        class="text-xl w-10"
                        :class="selectedForm === index ? 'far fa-dot-circle text-green-400' : 'far fa-circle text-gray-600'"
                    ></i>
                    <div class="flex items-baseline">
                        <h5 class="text-lg">{{ form.name }}</h5>
                        <span class="text-sm text-medium ml-2">{{ form.fields.length }} Fields</span>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>This project does not have any forms yet. Go create some!</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "AnnotationTaskField",
    mounted() {
        axios.get(this.formsPath)
            .then(response => this.forms = response.data)
            .catch(errors => console.log(errors));
    },
    props: {
        value: Object,
        formsPath: String
    },
    computed: {
        task: {
            get() {
                return this.value
            },
            set(newValue) {
                this.$emit('input', newValue)
            }
        }
    },
    data() {
        return {
            forms: [],
            selectedForm: -1
        }
    }
}
</script>

<style scoped>

</style>
