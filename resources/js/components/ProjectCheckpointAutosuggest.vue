<template>
    <div>
        <vue-autosuggest
            :suggestions="filteredOptions"
            :input-props="{id:'autosuggest_input', class: 'input', placeholder:'Add a checkpoint...'}"
            v-model="query"
            @selected="onSelected"
        >
            <template slot-scope="{ suggestion }">
                <span>{{ suggestion.item.name }}</span>
            </template>
        </vue-autosuggest>
    </div>
</template>

<script>
import {VueAutosuggest} from "vue-autosuggest";

export default {
    name: "ProjectCheckpointAutosuggest",
    components: {
        VueAutosuggest
    },
    props: {
        value: {
            type: Object,
            default: () => ({})
        },
        initialQuery: {
            type: String,
            default: ""
        },
        checkpoints: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            query: this.initialQuery
        }
    },
    computed: {
        filteredOptions() {
            return [{
                data: this.checkpoints.filter(checkpoint => {
                    return checkpoint.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1;
                })
            }];
        },
        proxyValue: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue); }
        }
    },
    methods: {
        onSelected(item) {
            this.proxyValue = item.item;
        }
    }
}
</script>

<style lang="scss">
#autosuggest {
    @apply relative;
}
.autosuggest__results-container {
    @apply absolute bg-white rounded-b shadow z-10;
}
.autosuggest__results-item {
    @apply p-2 cursor-pointer;
    &:hover {
        @apply bg-gray-200;
    }
}
</style>
