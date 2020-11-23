<template>
  <div>
    <div
        v-for="(field, index) in fields"
        :key="index"
        :class="field.type_name === 'section' ? 'mt-16 border-t-4 border-green-400' : ''"
        class="bg-white mb-4 rounded shadow p-4"
    >
      <component
          :is="`${field.slug}-task-field`"
          :id="`${index}-${field.type_name}`"
          v-model="fields[index]"
          :field-index="index"
          :project="project"
          @down="down"
          @duplicate="duplicateField"
          @remove="removeField"
          @up="up"
      ></component>
    </div>

    <button
        type="button"
        class="mb-4 text-gray-500 text-lg font-medium rounded flex flex-col bg-gray-300 hover:shadow-2xl transition-shadow duration-200 justify-center items-center w-full py-4 focus:outline-none"
        @click="$modal.show('task-selection')"
    ><i class="fas fa-tasks mr-2"></i>Add a task
    </button>
    <task-selection-modal v-model="fields"></task-selection-modal>
  </div>
</template>

<script>
import BuilderFieldsMixin from "../BuilderFieldsMixin";
import AnnotationTaskField from "./AnnotationTaskField";
import PointingTaskField from "./PointingTaskField";
import TaskSelectionModal from "./TaskSelectionModal";

export default {
  name: "ScenarioBuilder",
  components: {
    AnnotationTaskField,
    PointingTaskField,
    TaskSelectionModal
  },
  props: {
    project: Object
  },
  mixins: [
    BuilderFieldsMixin
  ],
  methods: {
    add(type) {
      this.fields.push(make(type))
    }
  }
}
</script>

