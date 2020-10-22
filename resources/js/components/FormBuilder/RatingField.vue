<template>
    <div>
        <field-header
            title="Rating"
            :required="proxyValue.required"
            @remove="$emit('remove', fieldIndex)"
            @duplicate="$emit('duplicate', fieldIndex)"
            @up="$emit('up', fieldIndex)"
            @down="$emit('down', fieldIndex)"
        ></field-header>
        <div class="mb-4">
            <input type="text" class="input font-bold mb-2" v-model="proxyValue.question">
            <input type="text" class="input" v-if="proxyValue.show_subtitle" v-model="proxyValue.subtitle">
        </div>
        <div class="py-4 flex items-center justify-center">
            <span class="mx-1 input-label" v-if="proxyValue.show_labels">{{ proxyValue.lower_bound_label }}</span>
            <i class="far fa-circle text-3xl text-gray-600 mx-1" v-for="n in proxyValue.levels"></i>
            <span class="mx-1 input-label" v-if="proxyValue.show_labels">{{ proxyValue.upper_bound_label }}</span>
        </div>
        <div class="mb-4 flex -mx-2">
            <div class="flex-1 mx-2">
                <label class="input-label">Levels</label>
                <div class="relative flex items-center">
                    <select class="input" v-model="proxyValue.levels">
                        <option v-for="n in [2,3,4,5,6,7]" :value="n">{{ n }}</option>
                    </select>
                    <i class="fas fa-caret-down absolute right-0 mr-4"></i>
                </div>
            </div>
            <div class="flex-1 mx-2">
                <label class="input-label">1 Label</label>
                <input type="text" class="input" v-model="proxyValue.lower_bound_label">
            </div>
            <div class="flex-1 mx-2">
                <label class="input-label">{{ proxyValue.levels }} Label</label>
                <input type="text" class="input" v-model="proxyValue.upper_bound_label">
            </div>
        </div>
        <div class="-mx-4 mt-4 px-4 pt-4 border-t flex justify-end">
            <button
                class="btn btn-gray-text"
                @click="proxyValue.show_labels = !proxyValue.show_labels"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.show_labels"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Show labels
            </button>
            <button
                class="btn btn-gray-text"
                @click="proxyValue.show_subtitle = !proxyValue.show_subtitle"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.show_subtitle"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Show subtitle
            </button>
            <button
                class="btn btn-gray-text"
                @click="proxyValue.required = !proxyValue.required"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.required"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Required
            </button>
        </div>
    </div>
</template>

<script>
import FieldHeader from "./FieldHeader";

export default {
    name: "RatingField",
    components: {
        FieldHeader
    },
    props: {
        value: Object,
        fieldIndex: Number
    },
    computed: {
        proxyValue: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    },
    methods: {
    }
}
</script>
