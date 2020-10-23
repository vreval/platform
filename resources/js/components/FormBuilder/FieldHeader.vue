<template>
    <div class="flex items-center justify-between">
        <h4 class="text-xs font-medium tracking-wider uppercase text-gray-600">{{ title }}<span v-if="required" class="text-red-600"> (*)</span></h4>
        <div class="flex">
            <button @click="$emit('duplicate')" type="button" class="btn btn-icon ml-4"><i class="far fa-copy"></i></button>
            <button @click="$emit('remove')" type="button" class="btn btn-icon ml-4"><i class="far fa-trash-alt"></i></button>
            <button @click="$emit('up')" type="button" class="btn btn-icon ml-4"><i class="fas fa-arrow-up"></i></button>
            <button @click="$emit('down')" type="button" class="btn btn-icon ml-4"><i class="fas fa-arrow-down"></i></button>
        </div>
    </div>
</template>

<script>
export default {
    name: "FieldHeader",
    props: {
        title: String,
        required: Boolean
    }
}
</script>
