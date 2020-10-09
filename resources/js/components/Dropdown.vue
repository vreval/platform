<template>
    <div class="dropdown min-w-32 relative">
        <div
            aria-haspopup="true"
            :aria-expanded="isOpen"
            class="dropdown-toggle"
            @click.prevent="toggle"
        >
            <slot name="trigger"></slot>
        </div>

        <div v-if="isOpen" class="dropdown-menu absolute bg-white rounded-lg shadow mt-2 w-full overflow-hidden">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dropdown",
    data() {
        return {isOpen: false}
    },
    methods: {
        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                document.addEventListener('click', this.closeSelf);
            }
        },
        closeSelf(event) {
            if (!event.target.closest('.dropdown')) {
                this.isOpen = false;
                document.removeEventListener('click', this.closeSelf);
            }
        }
    }
}
</script>
