<template>
    <div class="w-full">
        <a :href="`/projects/${item.project_id}/forms/${item.id}`" class="block flex w-full">
            <div
                v-for="(column, index) in headers"
                :key="index"
                class="px-4 py-2"
                :style="{ width: column.width }"
            >{{ item[column.name] }}</div>
            <div class="px-4 py-2 w-32 text-right">
            </div>
        </a>
    </div>
</template>

<script>
export default {
    name: "FormsTableRow",
    props: {
        headers: {
            type: Array,
            required: true
        },
        item: {
            type: Object,
            required: true
        }
    },
}
</script>

