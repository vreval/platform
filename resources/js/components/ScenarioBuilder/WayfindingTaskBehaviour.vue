<template>
<div>
  <input type="number" v-model.number="proxyValue.perimeter_boundary">
</div>
</template>

<script>
export default {
  name: "WayfindingTaskBehaviour",
  props: {
    value: {
      required: true,
      type: Object
    }
  },
  computed: {
    proxyValue: {
      get() { return this.value },
      set(newValue) { this.$emit('input', newValue) }
    }
  }

}
</script>

<style scoped>

</style>
