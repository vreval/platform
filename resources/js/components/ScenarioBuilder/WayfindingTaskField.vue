<template>
  <div>
    <field-header
        :title="`${fieldIndex + 1} Wayfinding Task`"
        @down="$emit('down', fieldIndex)"
        @duplicate="$emit('duplicate', fieldIndex)"
        @remove="$emit('remove', fieldIndex)"
        @up="$emit('up', fieldIndex)"
    ></field-header>

    <!-- Body ------------------------------------------------------------------------------------------------ -->
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
          <textarea v-model="proxyValue.description" class="input mb-2"
                    placeholder="Describe the task to your participants in enough detail..."
                    rows="5"></textarea>
        </div>

        <div class="mb-2">
          <label class="input-label">Checkpoints</label>
          <div class="mb-2 flex items-center w-full" v-for="(checkpoint, checkpointIndex) in proxyValue.checkpoints">
            <div class="relative flex items-center w-full">
              <select class="input" v-model="proxyValue.checkpoints[checkpointIndex]">
                <option v-for="checkpoint in checkpoints" :key="checkpoint.id" :value="checkpoint.id">{{ checkpoint.name }}</option>
                <option v-if="checkpoint.length === 0" :value="null" selected disabled>You haven't created any checkpoints yet.</option>
              </select>
              <i class="fas fa-caret-down absolute right-0 mr-4"></i>
            </div>
            <button class="ml-2 btn btn-gray-text" @click="removeCheckpoint(checkpointIndex)"><i class="fas fa-trash"></i></button>
            <button class="ml-2 btn btn-gray-text" @click="moveCheckpointUp(checkpointIndex)"><i class="fas fa-arrow-up"></i></button>
            <button class="ml-2 btn btn-gray-text" @click="moveCheckpointDown(checkpointIndex)"><i class="fas fa-arrow-down"></i></button>
          </div>
          <div>
            <button class="btn btn-green-outline" @click="addCheckpoint"><i class="fas fa-plus"></i> Add Checkpoint</button>
          </div>

        </div>

      </div>
      <WayfindingTaskBehaviour v-model="value.behaviour" />
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
import WayfindingTaskBehaviour from "./WayfindingTaskBehaviour";

export default {
  name: "WayfindingTaskField",
  components: {
    WayfindingTaskBehaviour,
    FieldHeader,
  },
  mixins: [BuilderFieldMixin],
  props: {
    project: Object,
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
  },
  data() {
    return {
      checkpoints: this.project.checkpoints,
      forms: this.project.forms,
    }
  },
  methods: {
    addCheckpoint() {
      this.proxyValue.checkpoints.push({
        id: 1,
      });
    },
    removeCheckpoint(index) {
      this.proxyValue.checkpoints.splice(index, 1);
    },
    moveCheckpointUp(index) {
      const tmp = JSON.parse(JSON.stringify(this.proxyValue.checkpoints[index]));
      this.removeCheckpoint(index);
      this.proxyValue.checkpoints.splice(index - 1, 0, tmp);
    },
    moveCheckpointDown(index) {
      const tmp = JSON.parse(JSON.stringify(this.proxyValue.checkpoints[index]));
      this.removeCheckpoint(index);
      this.proxyValue.checkpoints.splice(index + 1, 0, tmp);
    },
  }
}
</script>
