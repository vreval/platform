<template>
  <div>
    <field-header
        title="Annotation Task"
        @down="$emit('down', fieldIndex)"
        @duplicate="$emit('duplicate', fieldIndex)"
        @remove="$emit('remove', fieldIndex)"
        @up="$emit('up', fieldIndex)"
    ></field-header>
    <div class="mb-2">
      <textarea rows="5" class="input mb-2" v-model="proxyValue.description" placeholder="Describe the task to your participants in enough detail..."></textarea>
    </div>
    <div class="mb-2">
      <label class="input-label">Select a form the annotations should use</label>
      <select class="input">
        <option value="form">Some form</option>
      </select>
    </div>
  </div>
</template>

<script>
import FieldHeader from "../FormBuilder/FieldHeader";

export default {
  name: "AnnotationTaskField",
  components: {
    FieldHeader
  },
  props: {
    value: Object,
    fieldIndex: Number
  },
  computed: {
    proxyValue: {
      get() {
        return this.value
      },
      set(newValue) {
        this.$emit('input', newValue)
      }
    }
  }

}
</script>
