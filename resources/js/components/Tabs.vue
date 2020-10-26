<template>
    <div>
        <div class="mb-4">
            <ul class="flex border-b-2">
                <li v-for="(tab, index) in tabs" :key="index"
                    :class="{ 'border-b-2 border-green-400': tab.isActive }"
                    style="margin-bottom: -2px"
                >
                    <a
                        :href="tab.ref"
                        class="btn btn-gray-text font-medium tracking-wider text-gray-600 cursor-pointer block py-3"
                        :class="{ 'text-green-400': tab.isActive }"
                        @click="selectedTab(tab)"
                    >{{ tab.name }}</a>
                </li>
            </ul>
        </div>

        <div class="tabs-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Tabs",
    data() {
        return {
            tabs: []
        }
    },
    created() {
        this.tabs = this.$children;
    },
    methods: {
        selectedTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name === selectedTab.name);
            })
        }
    }
}
</script>
