<template>
  <div>
    <field-header
        :title="`${fieldIndex + 1} Pointing Task`"
        @down="$emit('down', fieldIndex)"
        @duplicate="$emit('duplicate', fieldIndex)"
        @remove="$emit('remove', fieldIndex)"
        @up="$emit('up', fieldIndex)"
    ></field-header>

    <div class="-mx-4 mt-4 px-4 pt-4 border-t">
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


    <div class="-mx-4 mt-4 px-4 pt-4 border-t">
      <!-- Body ------------------------------------------------------------------------------------------------ -->
      <div class="mb-2">
        <label class="input-label">Description</label>
        <textarea v-model="proxyValue.description" class="input mb-2"
                  placeholder="Describe the task to your participants in enough detail..."
                  rows="5"></textarea>
      </div>

      <div class="mb-2">
        <label class="input-label">How many points should be placed?</label>
        <div class="relative flex items-center">
          <span class="input-label mr-2">{{ proxyValue.count }}</span>
          <input type="range" min="1" max="10" step="1" v-model="proxyValue.count">
        </div>
      </div>
    </div>

    <div class="-mx-4 mt-4 px-4 pt-4 border-t">
      <div class="mb-2">
        <input id="customize-task-settings" type="checkbox" v-model="customTaskSettings">
        <label for="customize-task-settings" class="input-label">Customize task defaults</label>
        <textarea v-if="customTaskSettings" class="input font-mono" rows="5">{{ JSON.stringify(settings, null, 2) }}</textarea>
      </div>

      <div class="mb-2">
        <input id="customize-avatar-behaviour" type="checkbox" v-model="customAvatarBehaviour">
        <label for="customize-avatar-behaviour" class="input-label">Customize avatar behaviour</label>
        <textarea v-if="customAvatarBehaviour" class="input font-mono" rows="5">{{ JSON.stringify(avatarBehaviour, null, 2) }}</textarea>
      </div>
    </div>

    <!-- Footer ------------------------------------------------------------------------------------------------ -->
    <div class="-mx-4 mt-4 px-4 pt-4 border-t flex justify-end">
      <span>Footer</span>
    </div>
  </div>
</template>

<script>
import FieldHeader from "../FormBuilder/FieldHeader";

export default {
  name: "PointingTaskField",
  components: {
    FieldHeader
  },
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
