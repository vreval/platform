<template>
    <div class="bg-white shadow rounded">
        <div class="w-full flex text-xs text-gray-600 font-medium uppercase">
            <div
                v-for="(header, index) in options.headers"
                :key="index"
                :style="{ width: header.width }"
                class="px-4 py-2"
            >
                {{ header.text }}
            </div>
            <div class="px-4 py-2 w-32"></div>
        </div>
        <div
            v-for="(item, itemIndex) in computedItems"
            :key="itemIndex"
            class="w-full flex hover:bg-gray-200"
            :class="itemIndex < items.length - 1 ? 'border-b' : ''"
        >
            <component :headers="options.headers" :is="itemComponent" :item="item"></component>
        </div>
    </div>
</template>

<script>
export default {
    name: "Table",
    props: {
        options: {
            type: Object,
        },
        items: {
            type: Array,
            required: true
        },
        itemComponent: {
            type: String,
            required: true
        }
    },
    computed: {
        computedItems() {
            return this.items.sort((a, b) => {
                if (a[this.options.orderBy] < b[this.options.orderBy]) return -1;
                if (a[this.options.orderBy] > b[this.options.orderBy]) return 1;
                return 0;
            });
        }
    },
};
</script>
