<template>
  <div class="flex w-full">
    Change default setting:
    <div class="flex">
      <button v-for="option in options" class="btn btn-gray-text">{{ option.label }}</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "KeyValueList",
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
    },
    // filteredOptions() {
    //   return this.options.map(option => Object.keys(this.value).indexOf(option) >= 0);
    // }
  },
  data() {
    return {
      options: [
        {
          label: 'Time to answer (min)',
          key: 'time_to_answer_min',
          value: 120
        },
        {
          label: 'Time to answer (max)',
          key: 'time_to_answer_max',
          value: 300
        },
        {
          label: 'Maximum distance to Walk',
          key: 'walking_distance_max',
          value: 500
        },
        {
          label: 'Restrict walkable area',
          key: 'walking_perimeter_boundary',
          value: false
        },
        {
          label: 'Turn on tracking?',
          key: 'is_tracking',
          value: true
        },
        {
          label: 'Samples per second',
          dependsOn: 'is_tracking',
          key: 'samples_per_second',
          value: 4
        },
      ]
    }
  },
  methods: {
    add() {
      this.proxyValue.push(this.options[0]);
    }
  }
}
</script>
