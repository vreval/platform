<template>
  <modal
      :classes="['modal', 'my-4']"
      :max-width="960"
      :shiftY="0.2"
      height="auto"
      name="task-selection"
      scrollable
  >
    <h2 class="text-xl">Choose a method for your task...</h2>
    <ul class="-mx-10">
      <li v-for="(option, key) in options" :key="key"
          class="hover:bg-gray-200 cursor-pointer p-4 mb-2 flex items-center" @click="select(option.type)">
        <i :class="option.icon" class="text-gray-600 text-4xl w-40 text-center mr-4"></i>
        <div>
          <h4 class="text-lg font-medium text-gray-600">{{ option.name }}</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ad at autem consequuntur corporis, eaque
            eligendi eos expedita, fuga fugit in libero officiis quam qui quidem repellendus sed, veritatis
            voluptate.</p>
        </div>
      </li>
    </ul>
  </modal>
</template>

<script>
import make from "./ScenenarioTaskFactory";

export default {
  name: "TaskSelectionModal",
  props: {
    value: Array
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
      options: [
        {
          type: "annotation",
          name: "Annotation",
          icon: "fas fa-tags"
        },
        {
          type: "pointing",
          name: "Pointing",
          icon: "fas fa-hand-point-up"
        },
        {
          type: "wayfinding",
          name: "Wayfinding",
          icon: "fas fa-route"
        },
        {
          type: "placing",
          name: "Placing",
          icon: "fas fa-map-pin"
        },
        {
          type: "camera-path",
          name: "Camera Path",
          icon: "fas fa-video"
        },
      ],
    }
  },
  methods: {
    select(type) {
      this.proxyValue.push(make(type));
      this.$modal.hide('task-selection');
    }
  }
}
</script>
