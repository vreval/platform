<template>
    <div class="bg-white shadow rounded">
        <div class="mb-4 p-4 flex items-center" v-if="useFilter">
            <i class="fas fa-filter ml-4 text-gray-600 absolute"></i>
            <input type="text" class="input-icon-left text-lg text-gray-600 font-bold">
        </div>
        <div class="w-full flex text-xs text-gray-600 font-medium uppercase">
            <div
                v-for="(header, index) in headers"
                :key="index"
                :style="{ width: header.width }"
                class="px-4 py-2"
            >
                {{ header.text }}
            </div>
            <div class="px-4 py-2 w-12">
            </div>
        </div>
        <div
            v-for="(row, rowIndex) in content"
            :key="rowIndex"
            class="w-full flex hover:bg-gray-200"
            :class="rowIndex < content.length - 1 ? 'border-b' : ''"
        >
            <div @click="$emit('clicked-row', row)" class="w-full flex">
                <div
                    v-for="(column, columnIndex) in headers"
                    :key="columnIndex"
                    :style="{ width: column.width }"
                    class="px-4 py-2"
                >
                    {{ row[column.fieldName] }}
                </div>
            </div>
            <div class="flex items-center w-12">
                <button @click.prevent="toggle(row.id, row.isPinned)" class="w-6 h-6">
                    <i class="fas fa-thumbtack" :class="row.isPinned ? 'text-gray-800' : 'text-gray-400'"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Table",
    props: {
        useFilter: { type: Boolean },
        initialContent: { type: Array },
        headers: { type: Array },
        content: { type: Array }
    },
    data() {
        return {
            checked: false,
        };
    },
    methods: {
        toggle(id, isPinned) {
            axios[isPinned ? 'delete' : 'post'](`/projects/${id}/pins`)
                .then(response => (location = '/projects'))
                .catch(error => console.log(error));
        }
    }
};
</script>
