<template>
  <div>
    <field-header
        :title="`${fieldIndex + 1} Annotation Task`"
        @down="$emit('down', fieldIndex)"
        @duplicate="$emit('duplicate', fieldIndex)"
        @remove="$emit('remove', fieldIndex)"
        @up="$emit('up', fieldIndex)"
    ></field-header>

    <div v-if="collapsed" class="-mx-4 p-4 border-b cursor-pointer" @click="open(fieldIndex)">
      <span class="input-label">Description</span>
      <p>{{ proxyValue.description }}</p>
    </div>

    <div v-else>
      <div class="-mx-4 p-4 border-b">
        <div class="mb-2 flex -mx-2">
          <div class="w-1/2 mx-2">
            <label class="input-label">Start checkpoint:</label>
            <div class="relative flex items-center">
              <select class="input" v-model="proxyValue.start_checkpoint_id">
                <option v-if="checkpoints.length === 0" :value="null" selected disabled>You haven't created any checkpoints yet.</option>
                <option v-for="form in checkpoints" :key="form.id" :value="form.id">{{ form.name }}</option>
              </select>
              <i class="fas fa-caret-down absolute right-0 mr-4"></i>
            </div>
          </div>

          <div class="w-1/2 mx-2">
            <label class="input-label">Start form:</label>
            <div class="relative flex items-center">
              <select class="input" v-model="proxyValue.start_form_id">
                <option v-for="form in forms" :key="form.id" :value="form.id">{{ form.name }}</option>
                <option v-if="forms.length === 0" :value="null" selected disabled>You haven't created any forms yet.</option>
              </select>
              <i class="fas fa-caret-down absolute right-0 mr-4"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="-mx-4 p-4 border-b">
        <div class="mb-2">
          <label class="input-label">Description</label>
          <textarea v-model="proxyValue.settings.description" class="input mb-2"
                    placeholder="Describe the task to your participants in enough detail..."
                    rows="5"></textarea>
        </div>

        <div class="mb-2">
          <label class="input-label">Select a form the annotations should use</label>
          <div class="relative flex items-center">
            <select class="input" v-model="proxyValue.form_id">
              <option v-if="forms.length === 0" value="null" disabled>You haven't created any forms yet.</option>
              <option v-for="form in forms" :key="form.id" :value="form.id">{{ form.name }}</option>
            </select>
            <i class="fas fa-caret-down absolute right-0 mr-4"></i>
          </div>
        </div>

        <div class="mb-2">
          <label class="input-label">How many annotations should be placed?</label>
          <div class="relative flex items-center">
            <span class="input-label mr-2">{{ proxyValue.settings.count }}</span>
            <input type="range" min="1" max="10" step="1" v-model.number="proxyValue.settings.count">
          </div>
        </div>
      </div>
    </div>

    <!-- Footer ------------------------------------------------------------------------------------------------ -->
    <div class="pt-4 flex justify-end">
      <span>Footer</span>
    </div>
  </div>
</template>

<script>
import FieldHeader from "../FormBuilder/FieldHeader";
import BuilderFieldMixin from "../BuilderFieldMixin";

export default {
  name: "AnnotationTaskField",
  mixins: [BuilderFieldMixin],
  components: {
    FieldHeader
  },
  props: {
    collapsed: Boolean,
    fieldIndex: Number,
    project: Object,
    value: Object,
  },
  computed: {
    proxyValue: {
      get() {
        return this.value
      },
      set(newValue) {
        this.$emit('input', newValue)
      }
    },
  },
  data() {
    return {
      checkpoints: this.project.checkpoints,
      forms: this.project.forms,
    }
  }
}
</script>
