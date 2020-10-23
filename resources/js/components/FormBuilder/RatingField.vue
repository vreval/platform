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

        <!-- Header ------------------------------------------------------------------------------------------------ -->
        <div class="mb-4 flex -mx-2">
            <div class="w-1/2 mx-2">
                <label class="input-label">Question</label>
                <input type="text" class="input font-bold mb-2" v-model="proxyValue.question" placeholder="Type your question here...">
                <label class="input-label" v-if="proxyValue.show_subtitle">Subtitle</label>
                <input type="text" class="input" v-if="proxyValue.show_subtitle" v-model="proxyValue.subtitle">
            </div>
            <div class="w-1/4 mx-2">
                <label class="input-label">Levels</label>
                <div class="relative flex items-center">
                    <select class="input" v-model="proxyValue.levels">
                        <option v-for="level in Array.prototype.range(2, 7, 1)" :key="'level-' + level" :value="level">{{ level }}</option>
                    </select>
                    <i class="fas fa-caret-down absolute right-0 mr-4"></i>
                </div>
            </div>
            <div class="w-1/4 mx-2">
                <label class="input-label">Symbols</label>
                <div class="relative flex items-center">
                    <select class="input" v-model="proxyValue.symbols_selection">
                        <option v-for="(symbol, index) in proxyValue.symbols" :key="'symbol-' + symbol" :value="symbol">{{ symbol }}</option>
                    </select>
                    <i class="fas fa-caret-down absolute right-0 mr-4"></i>
                </div>
            </div>
        </div>

        <!-- Preview ----------------------------------------------------------------------------------------------- -->
        <div class="my-4">
            <div class="flex justify-center">
                <span class="text-center input-label w-10" v-for="(symbol, index) in symbolRange" :key="'symbol-label-' + index">{{ symbol }}</span>
            </div>
            <div class="py-2 flex items-center justify-center" v-for="(item, labelIndex) in proxyValue.items" :key="'circles-' + labelIndex">
                <span class="mx-1 input-label block w-1/4 text-right" v-if="proxyValue.show_labels">{{ item.lower_bound_label }}</span>
                <div class="w-1/2 flex justify-center">
                    <div class="w-10 text-center" v-for="n in proxyValue.levels" :key="n + 'n'">
                        <i class="far fa-circle text-3xl text-gray-600 mx-1"></i>
                    </div>
                </div>
                <span class="mx-1 input-label block w-1/4" v-if="proxyValue.show_labels">{{ item.upper_bound_label }}</span>
            </div>
        </div>

        <!-- Label Input ------------------------------------------------------------------------------------------- -->
        <div class="my-4">
            <div class="mb-4 flex -mx-2" v-if="proxyValue.show_labels" v-for="(item, itemIndex) in proxyValue.items" :key="itemIndex + 'item'">
                <div class="flex-1 mx-2 flex items-center">
                    <label class="input-label w-20 text-right pr-2">1 Label</label>
                    <input type="text" class="input" v-model="proxyValue.items[itemIndex].lower_bound_label">
                </div>
                <div class="flex-1 mx-2 flex items-center">
                    <label class="input-label w-20 text-right pr-2">{{ proxyValue.levels }} Label</label>
                    <input type="text" class="input" v-model="proxyValue.items[itemIndex].upper_bound_label">
                </div>
                <button
                    class="btn"
                    :class="itemIndex !== 0 ? 'btn-icon' : 'btn-icon-disabled'"
                    :disabled="itemIndex === 0"
                    @click="removeItem(itemIndex)"
                ><i class="far fa-trash-alt"></i></button>
            </div>
        </div>
        <button class="btn btn-green-outline text-xs" @click="addItem">Add item</button>

        <!-- Footer ------------------------------------------------------------------------------------------------ -->
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
        },
        symbolRange() {
            const x = this.proxyValue.levels;
            const symbolGenerators = {
                none: () => [],
                asc: () => Array.prototype.range(1, x, 1),
                mirror: () => {
                    let range = Array.prototype.range(Math.floor(x/2) * -1, Math.floor(x/2), 1);
                    if (!(x % 2)) range.splice(x/2, 1);
                    return range;
                },
                pos_neg: () => {
                    let range = Array.prototype.range(Math.floor(x/2) * -1, Math.floor(x/2), 1);
                    if (!(x % 2)) range.splice(x/2, 1);
                    return range.map(item => {
                        if (item === 0) return 0;
                        return item < 0 ? '-'.repeat(Math.abs(item)) : '+'.repeat(item);
                    });
                }
            }

            return symbolGenerators[this.proxyValue.symbols_selection]();
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
        },
    }
}
</script>
