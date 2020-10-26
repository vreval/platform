<template>
    <div>
        <component
            v-model="task"
            v-if="task.type"
            :forms-path="formsPath"
            :is="makeComponentName(task.type)"
            @remove="task.type = 'none'"
        ></component>
        <button
            type="button"
            class="mb-4 text-gray-500 text-lg font-medium rounded flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center w-full py-4 focus:outline-none"
            @click="$modal.show('task-selection')"
        ><i class="fas fa-tasks mr-2"></i>{{ task.type === 'none' ? 'Assign a task' : 'Assign a different task' }}
        </button>
        <task-selection-modal v-model="task"></task-selection-modal>
    </div>
</template>

<script>
import TaskSelectionModal from "./TaskSelectionModal";
import NoneTaskField from "./NoneTaskField";
import AnnotationTaskField from "./AnnotationTaskField";
import PointingTaskField from "./PointingTaskField";

export default {
    name: "TaskSlot",
    components: {
        TaskSelectionModal,
        NoneTaskField,
        AnnotationTaskField,
        PointingTaskField,
    },
    props: {
        value: {
            type: Object,
            required: true
        },
        formsPath: {
            type: String,
            required: true
        }
    },
    computed: {
        task: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    },
    methods: {
        makeComponentName(typeName) {
            console.log(typeName)
            return typeName.replace(/App\\/g, '')
                .toLowerCase() + '-task-field'
        }
    }
}
</script>
