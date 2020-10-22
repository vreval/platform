<template>
    <div>
        <field-header
            title="Paragraph"
            @remove="$emit('remove', fieldIndex)"
            @duplicate="$emit('duplicate', fieldIndex)"
            @up="$emit('up', fieldIndex)"
            @down="$emit('down', fieldIndex)"
        ></field-header>
        <div class="mb-2">
            <textarea class="input" rows="5" v-model="proxyValue.text" placeholder="Type your paragraph here..."></textarea>
        </div>
    </div>
</template>

<script>
import FieldHeader from "./FieldHeader";
export default {
    name: "TextField",
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
