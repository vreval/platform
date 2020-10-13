<template>
    <vue-autosuggest
        v-model="query"
        :input-props="{
            id: 'autosuggest_input',
            class: 'input',
            placeholder: 'Type the name of another user...'
        }"
        :suggestions="filteredOptions"
        @input="onInputChange"
        @selected="onSelected"
    >
        <template slot-scope="{ suggestion }">
            <div class="flex items-center">
                <img
                    :src="suggestion.item.gravatar_url"
                    alt=""
                    class="rounded-full w-8 mr-4"
                />
                <div>{{ suggestion.item.name }}</div>
            </div>
        </template>
    </vue-autosuggest>
</template>

<script>
import { VueAutosuggest } from "vue-autosuggest";
import axios from "axios";

export default {
    name: "ProjectUserAutosuggest",
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
        initialOptions: {
            type: Array
        }
    },
    data() {
        return {
            query: this.initialQuery,
            options: []
        };
    },
    computed: {
        filteredOptions() {
            return [
                {
                    data: this.options.filter(option => {
                        return (
                            option.name
                                .toLowerCase()
                                .indexOf(this.query.toLowerCase()) > -1
                        );
                    })
                }
            ];
        },
        proxyValue: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit("input", newValue);
            }
        }
    },
    methods: {
        onSelected(item) {
            this.proxyValue = item.item;
        },
        onInputChange() {
            this.proxyValue = {};
            axios.get(`/users?search=${this.query}`).then(response => {
                this.options = response.data.search_result;
            });
        }
    }
};
</script>
