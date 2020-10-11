<template>
    <div class="bg-white shadow rounded">
        <div class="mb-4 p-4 flex items-center" v-if="useFilter">
            <i class="fas fa-filter ml-4 text-gray-600 absolute"></i>
            <input type="text" class="input-icon-left text-lg text-gray-600 font-bold">
        </div>
        <div class="w-full flex text-xs text-gray-600 font-medium uppercase">
            <div class="px-4 py-2 w-12">
            </div>
            <div
                v-for="(header, index) in headers"
                :key="index"
                :style="{ width: header.width }"
                class="px-4 py-2"
            >
                {{ header.text }}
            </div>
        </div>
        <div
            v-for="(row, rowIndex) in content"
            :key="rowIndex"
            class="w-full flex hover:bg-gray-200"
            :class="rowIndex < content.length - 1 ? 'border-b' : ''"
        >
            <div class="px-4 py-2 w-12">
                <checkbox v-model="checked"></checkbox>
            </div>
            <div @click="$emit('clicked-row', row)" class="w-full flex">
                <div
                    v-for="(value, key, valueIndex) in row"
                    :key="key"
                    :style="{ width: headers[valueIndex].size }"
                    class="px-4 py-2"
                >
                    {{ value }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Table",
    props: {
        useFilter: { type: Boolean },
        initialContent: { type: Array }
    },
    data() {
        return {
            checked: false,
            headers: [
                { text: "Name", width: `${200 / 4}%` },
                { text: "Size", width: `${100 / 4}%` },
                { text: "Actions", width: `${100 / 4}%` }
            ],
            content: [
                { name: "Testname", size: 2, action: "fly" },
                { name: "Leela", size: 3, action: "run" },
                { name: "Fry", size: 1, action: "walk" }
            ]
        };
    }
};
</script>
