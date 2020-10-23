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
        <div class="mb-4 flex -mx-2">
            <div class="w-2/3 mx-2">
                <label class="input-label">Question</label>
                <input type="text" class="input font-bold mb-2" v-model="proxyValue.question">
                <label class="input-label" v-if="proxyValue.show_subtitle">Subtitle</label>
                <input type="text" class="input" v-if="proxyValue.show_subtitle" v-model="proxyValue.subtitle">
            </div>
            <div class="w-1/3 mx-2">
                <label class="input-label">Levels</label>
                <div class="relative flex items-center">
                    <select class="input" v-model="proxyValue.levels">
                        <option v-for="level in [2,3,4,5,6,7]" :key="level + 'level'" :value="level">{{ level }}</option>
                    </select>
                    <i class="fas fa-caret-down absolute right-0 mr-4"></i>
                </div>
            </div>
        </div>
        <div class="my-4">
            <div class="py-2 flex items-center justify-center" v-for="(item, labelIndex) in proxyValue.items" :key="labelIndex + 'label'">
                <span class="mx-1 input-label block w-1/4 text-right" v-if="proxyValue.show_labels">{{ item.lower_bound_label }}</span>
                <div class="w-1/2 flex justify-center">
                    <i class="far fa-circle text-3xl text-gray-600 mx-1" v-for="n in proxyValue.levels" :key="n + 'n'"></i>
                </div>
                <span class="mx-1 input-label block w-1/4" v-if="proxyValue.show_labels">{{ item.upper_bound_label }}</span>
            </div>
        </div>
        <div class="my-4">
            <div class="mb-4 flex -mx-2" v-for="(item, itemIndex) in proxyValue.items" :key="itemIndex + 'item'">
                <div class="flex-1 mx-2 flex items-center">
                    <label class="input-label w-20">1 Label</label>
                    <input type="text" class="input" v-model="proxyValue.items[itemIndex].lower_bound_label">
                </div>
                <div class="flex-1 mx-2 flex items-center">
                    <label class="input-label w-20">{{ proxyValue.levels }} Label</label>
                    <input type="text" class="input" v-model="proxyValue.items[itemIndex].upper_bound_label">
                </div>
                <button class="px-3 py-1 text-gray-400 hover:text-gray-800" @click="removeItem(itemIndex)"><i class="far fa-trash-alt"></i></button>
            </div>
        </div>
        <button class="btn btn-green-outline text-xs" @click="addItem">Add item</button>
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
        addItem() {
            this.proxyValue.items.push({
                lower_bound_label: 'Label',
                upper_bound_label: 'Label'
            });
        },
        removeItem(index) {
            this.proxyValue.items.splice(index, 1);
        }
    }
}
</script>
