<template>
    <div class="flex-1 mr-4">
        <div class="mb-4">
            <label class="input-label" for="name">Name</label>
            <input
                id="name"
                v-model="proxyValue.name"
                :class="proxyValue.errors.name ? 'border border-red-600' : ''"
                class="input"
                type="text"
            />
            <div v-if="proxyValue.errors">
                <span
                    v-for="(error, index) in proxyValue.errors.name"
                    :key="index"
                    class="text-red-400 text-xs italic"
                    >{{ error }}</span
                >
            </div>
        </div>

        <div class="mb-4">
            <label class="input-label" for="description">Description</label>
            <textarea
                id="description"
                v-model="proxyValue.description"
                :class="proxyValue.errors.description ? 'border border-red-600' : ''"
                class="input"
                rows="5"
            ></textarea>
            <div v-if="proxyValue.errors">
                <span
                    v-for="(error, index) in proxyValue.errors.description"
                    :key="index"
                    class="text-red-400 text-xs italic"
                    >{{ error }}</span
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BasicFormFields",
    props: {
        value: {
            type: Object,
            required: true
        }
    },
    computed: {
        proxyValue: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    }
};
</script>
