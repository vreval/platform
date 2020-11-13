<template>
  <div>
    <field-header
        :title="`${fieldIndex + 1} Annotation Task`"
        @down="$emit('down', fieldIndex)"
        @duplicate="$emit('duplicate', fieldIndex)"
        @remove="$emit('remove', fieldIndex)"
        @up="$emit('up', fieldIndex)"
    ></field-header>

    <div v-if="customTaskSettings">
      <label class="input-label">Customize task defaults</label>
      <textarea class="input font-mono" rows="10">{{ JSON.stringify(settings, null, 2) }}</textarea>
    </div>

    <div v-if="customAvatarBehaviour" class="-mx-4 mt-4 px-4 pt-4 border-t">
      <label class="input-label">Customize avatar behaviour</label>
      <textarea class="input font-mono" rows="10">{{ JSON.stringify(avatarBehaviour, null, 2) }}</textarea>
    </div>

    <div class="-mx-4 mt-4 px-4 pt-4 border-t">
      <div class="mb-2 flex -mx-2">
        <div class="w-1/2 mx-2">
          <label class="input-label">Start checkpoint:</label>
          <div class="relative flex items-center">
            <select class="input">
              <option v-if="forms.length === 0" selected>You haven't created any checkpoints yet.</option>
              <option v-for="form in checkpoints" :key="form.id" :value="form.id">{{ form.name }}</option>
            </select>
            <i class="fas fa-caret-down absolute right-0 mr-4"></i>
          </div>
        </div>

        <div class="w-1/2 mx-2">
          <label class="input-label">Start form:</label>
          <div class="relative flex items-center">
            <select class="input">
              <option v-if="forms.length === 0" selected>You haven't created any forms yet.</option>
              <option v-for="form in forms" :key="form.id" :value="form.id">{{ form.name }}</option>
            </select>
            <i class="fas fa-caret-down absolute right-0 mr-4"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="-mx-4 mt-4 px-4 pt-4 border-t">
      <div class="mb-2">
        <label class="input-label">Description</label>
        <textarea v-model="proxyValue.description" class="input mb-2"
                  placeholder="Describe the task to your participants in enough detail..."
                  rows="5"></textarea>
      </div>

      <div class="mb-2">
        <label class="input-label">Select a form the annotations should use</label>
        <div class="relative flex items-center">
          <select class="input">
            <option v-if="forms.length === 0" selected>You haven't created any forms yet.</option>
            <option v-for="form in forms" :key="form.id" :value="form.id">{{ form.name }}</option>
          </select>
          <i class="fas fa-caret-down absolute right-0 mr-4"></i>
        </div>
      </div>

      <div class="mb-2">
        <label class="input-label">How many annotations should be placed?</label>
        <div class="relative flex items-center">
          <span class="mr-2">{{ amount }}</span>
          <input type="range" min="1" max="10" step="1" v-model="amount">
        </div>
      </div>
    </div>

    <!-- Footer ------------------------------------------------------------------------------------------------ -->
    <div class="-mx-4 mt-4 px-4 pt-4 border-t flex justify-end">
      <button
          class="btn btn-gray-text"
          @click="customTaskSettings = !customTaskSettings"
      >
        <i v-if="!customTaskSettings" class="far fa-circle mr-1"></i>
        <i v-else class="far fa-dot-circle text-green-400 mr-1"></i>
        Customize task defaults
      </button>
      <button
          class="btn btn-gray-text"
          @click="customAvatarBehaviour = !customAvatarBehaviour"
      >
        <i v-if="!customAvatarBehaviour" class="far fa-circle mr-1"></i>
        <i v-else class="far fa-dot-circle text-green-400 mr-1"></i>
        Customize avatar behaviour
      </button>
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
  },
  data() {
    return {
      amount: 3,
      checkpoints: [
        {id: 1, name: 'Baseline'},
        {id: 2, name: 'Recovery'},
        {id: 3, name: 'Stressor'},
      ],
      forms: [
        {id: 1, name: 'Fakeform 1'},
        {id: 2, name: 'Fakeform 2'},
        {id: 3, name: 'Fakeform 3'},
      ],
      customTaskSettings: false,
      customAvatarBehaviour: false,
      avatarBehaviour: {
        movement: "walking",
        speed: "default",
        walking_sound: false
      },
      settings: {
        answer_time_min: 120,
        answer_time_max: 300,
        walking_distance_max: 500,
        walking_perimeter_boundary: false,
        is_tracking: true,
        tracking_interval: 0.25
      }
    }
  }
}
</script>
