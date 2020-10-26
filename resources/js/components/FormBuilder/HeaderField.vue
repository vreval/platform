<template>
    <div>
        <field-header
            title="Header"
            @remove="$emit('remove', fieldIndex)"
            @duplicate="$emit('duplicate', fieldIndex)"
            @up="$emit('up', fieldIndex)"
            @down="$emit('down', fieldIndex)"
        ></field-header>
        <div class="mb-2">
            <input type="text" class="input mb-2 text-3xl" v-model="proxyValue.text" placeholder="Header Text" required>
            <input type="text" class="input" v-if="proxyValue.show_subtitle" v-model="proxyValue.subtitle" placeholder="Subtitle">
        </div>
        <div class="-mx-4 mt-4 px-4 pt-4 border-t flex justify-end">
            <button
                class="btn btn-gray-text"
                @click="proxyValue.show_subtitle = !proxyValue.show_subtitle"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.show_subtitle"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Show subtitle
            </button>
        </div>
    </div>
</template>

<script>
import FieldHeader from "./FieldHeader";
export default {
    name: "HeaderField",
    components: {
        FieldHeader
    },
    props: {
        value: Object,
        fieldIndex: Number
    },
    computed: {
        proxyValue: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    }

}
</script>
