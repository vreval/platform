<template>
    <a :href="`/projects/${item.id}`" class="block flex w-full">
        <div
            v-for="(column, index) in headers"
            :key="index"
            class="px-4 py-2"
            :style="{ width: column.width }"
        >{{ item[column.name] }}</div>
        <div class="px-4 py-2 w-32 text-right">
            <button
                type="button"
                class="focus:outline-none"
                @click.prevent="toggle(item.id, item.is_pinned)"
            ><i class="fas fa-thumbtack" :class="item.is_pinned ? 'text-gray-600' : 'text-gray-400'"></i></button>
        </div>
    </a>
</template>

<script>
import axios from "axios";

export default {
    name: "ProjectsTableRow",
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
    methods: {
        toggle(id, isPinned) {
            axios[isPinned ? 'delete' : 'post'](`/projects/${id}/pins`)
                .then(response => (location = '/projects'))
                .catch(error => console.log(error));
        }
    }
}
</script>

