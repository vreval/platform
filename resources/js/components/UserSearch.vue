<template>
    <div class="relative">
        <input
            type="text"
            class="input"
            :class="selectedUser !== null ? 'border border-green-400' : ''"
            @input="onChange"
            v-model="query"
        />
        <div
            v-if="loading || result.length > 0"
            class="absolute w-full bg-white py-2 border z-10"
        >
            <span v-if="loading" class="w-full text-left p-2">Hang on...</span>
            <button
                class="w-full hover:bg-gray-200 text-left p-2 focus:outline-none"
                type="button"
                v-for="(user, index) in result"
                :key="index"
                @click="select(user)"
            >
                {{ user.name }}<br />
                <span class="text-xs text-gray-400">{{ user.email }}</span>
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserSearch",
    props: {
        value: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            query: this.value ? this.value.name : "",
            result: [],
            timer: null,
            loading: false,
            selectedUser: this.value || null
        };
    },
    computed: {
        proxyValue: {
            get() {
                return this.value.id;
            },
            set(newValue) {
                this.$emit("input", newValue);
            }
        }
    },
    methods: {
        onChange() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.refresh();
                this.timer = null;
            }, 1000);
            this.loading = true;
            this.selectedUser = null;
        },
        refresh() {
            if (this.query === "") {
                this.result = [];
                this.loading = false;
                this.proxyValue = {};
                return;
            }

            axios.get(`/users?search=${this.query}`).then(response => {
                this.result = response.data.search_result;
                this.loading = false;
            });
        },
        select(user) {
            this.query = user.name;
            this.selectedUser = JSON.parse(JSON.stringify(user));
            this.result = [];
            this.proxyValue = user;
        }
    }
};
</script>
