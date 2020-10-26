<template>
    <modal
        :classes="['modal', 'my-4']"
        :max-width="960"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
        scrollable
        name="task-selection"
    >
        <h2 class="text-xl">Choose a method for your task...</h2>
        <ul class="-mx-10">
            <li class="hover:bg-gray-200 cursor-pointer p-4 mb-2 flex items-center" v-for="(option, key) in options" :key="key" @click="select(option.type)">
                <i class="text-gray-600 text-4xl w-40 text-center mr-4" :class="option.icon"></i>
                <div>
                    <h4 class="text-lg font-medium text-gray-600">{{ option.name }}</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ad at autem consequuntur corporis, eaque eligendi eos expedita, fuga fugit in libero officiis quam qui quidem repellendus sed, veritatis voluptate.</p>
                </div>
            </li>
        </ul>
    </modal>
</template>

<script>
import VrevalForm from "../VrevalForm";
export default {
    name: "TaskSelectionModal",
    props: {
        value: Object
    },
    computed: {
        selectedTask: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    },
    data() {
        return {
            options: [
                {
                    type: "App\\Annotation",
                    name: "Annotation",
                    icon: "fas fa-tags"
                },
                {
                    type: "App\\Pointing",
                    name: "Pointing",
                    icon: "fas fa-hand-point-up"
                },
                {
                    type: "App\\Wayfinding",
                    name: "Wayfinding",
                    icon: "fas fa-route"
                },
                {
                    type: "App\\Placing",
                    name: "Placing",
                    icon: "fas fa-map-pin"
                },
                {
                    type: "App\\CameraPath",
                    name: "Camera Path",
                    icon: "fas fa-video"
                },
            ],
        }
    },
    methods: {
        select(type) {
            this.selectedTask.type = type;
            this.selectedTask.description = "";
            this.$modal.hide('task-selection');
        }
    }
}
</script>
