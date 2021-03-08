<template>
  <modal
      :classes="['modal', 'my-4']"
      :shiftY="0.2"
      :width="768"
      height="auto"
      name="task-selection"
      scrollable
  >
    <h2 class="text-xl">Choose a method for your task...</h2>
    <ul class="-mx-10">
      <li v-for="option in options" :key="option.id"
          class="hover:bg-gray-200 cursor-pointer p-4 flex" @click="select(option)">
        <i :class="option.icon" class="text-gray-600 text-4xl w-1/6 text-center -ml-4 mt-4"></i>
        <div class="w-5/6">
          <h4 class="text-lg font-medium text-gray-600">{{ option.name }}</h4>
          <p>{{ option.description }}</p>
        </div>
      </li>
    </ul>
  </modal>
</template>

<script>
import axios from "axios";

export default {
  name: "TaskSelectionModal",
  props: {
    value: Array,
  },
  mounted() {
    axios.get('/task-types')
        .then(response => {
          this.options = response.data
        });
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
      options: [],
    }
  },
  methods: {
    select(type) {
      this.proxyValue.push(JSON.parse(JSON.stringify({
        settings: type.settings,
        slug: type.slug,
        type_id: type.id,
        collapsed: false
      })));
      this.$modal.hide('task-selection');
    }
  }
}
</script>
