<template>
    <div>
        <field-header
            title="New section"
            @remove="$emit('remove', fieldIndex)"
            @duplicate="$emit('duplicate', fieldIndex)"
            @up="$emit('up', fieldIndex)"
            @down="$emit('down', fieldIndex)"
        ></field-header>
    </div>
</template>

<script>
import FieldHeader from "./FieldHeader";
export default {
    name: "SectionField",
    components: {
        FieldHeader
    },
    props: {
        fieldIndex: Number
    }
}
</script>
