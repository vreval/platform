<template>
  <modal
      :classes="['modal', 'my-4']"
      :width="768"
      :shiftY="0.2"
      height="auto"
      name="task-selection"
      scrollable
  >
    <h2 class="text-xl">Choose a method for your task...</h2>
    <ul class="-mx-10">
      <li v-for="(option, key) in options" :key="key"
          class="hover:bg-gray-200 cursor-pointer p-4 flex" @click="select(option.type)">
        <i :class="option.icon" class="text-gray-600 text-4xl w-1/6 text-center -ml-4 mt-4"></i>
        <div class="w-5/6">
          <h4 class="text-lg font-medium text-gray-600">{{ option.name }}</h4>
          <p v-if="descriptions.length !== 0">{{ descriptions.find(d => d.id === option.id).description }}</p>
        </div>
      </li>
    </ul>
  </modal>
</template>

<script>
import axios from "axios";
import make from "./ScenenarioTaskFactory";

export default {
  name: "TaskSelectionModal",
  props: {
    value: Array
  },
  mounted() {
   axios.get('/task-types')
    .then(response => this.descriptions = response.data);
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
      descriptions: [],
      options: [
        {
          id: 1,
          type: "annotation",
          name: "Annotation",
          icon: "fas fa-tags"
        },
        {
          id: 2,
          type: "pointing",
          name: "Pointing",
          icon: "fas fa-hand-point-up"
        },
        {
          id: 3,
          type: "wayfinding",
          name: "Wayfinding",
          icon: "fas fa-route"
        },
        {
          id: 4,
          type: "placing",
          name: "Placing",
          icon: "fas fa-map-pin"
        },
        {
          id: 5,
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
