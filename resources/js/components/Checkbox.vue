<template>
    <button class="focus:outline-none" @click="proxyValue = !value">
        <i
            :class="value ? 'far fa-check-square text-green-500' : 'far fa-square text-gray-600'"
        ></i>
    </button>
</template>

<script>
export default {
    name: "Checkbox",
    props: {
        value: Boolean
    },
    computed: {
        proxyValue: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    },
}
</script>
