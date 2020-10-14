<template>
    <footer class="flex justify-between">
        <div>
            <button class="btn btn-green" type="button" @click="$emit('submit-clicked')">
                {{ submitText }}
            </button>
            <button
                class="btn btn-gray ml-2"
                type="button"
                @click="$emit('cancel-clicked')"
            >
                Cancel
            </button>
        </div>
        <div>
            <slot></slot>
        </div>
    </footer>
</template>

<script>
export default {
    name: "ModalFooter",
    props: {
        submitText: {
            type: String,
            required: true
        }
    }
}
</script>
