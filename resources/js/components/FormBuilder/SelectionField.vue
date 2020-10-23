<template>
    <div>
        <field-header
            title="Selection"
            :required="proxyValue.required"
            @remove="$emit('remove', fieldIndex)"
            @duplicate="$emit('duplicate', fieldIndex)"
            @up="$emit('up', fieldIndex)"
            @down="$emit('down', fieldIndex)"
        ></field-header>
        <div class="mb-4">
            <input type="text" class="input font-bold" v-model="proxyValue.question" placeholder="Type your question here...">
        </div>
        <div ref="options-container">
            <div v-for="(option, index) in proxyValue.options" :key="index" class="flex items-center mb-2 w-2/3">
                <i class="far fa-circle mr-4 text-gray-600"></i>
                <input type="text" class="input" v-model="proxyValue.options[index]">
                <button
                    class="icon"
                    :class="index <= 1 ? 'btn-icon-disabled' : 'btn-icon'"
                    :disabled="index <= 2"
                    @click="removeOption(index)"
                ><i class="far fa-trash-alt"></i></button>
            </div>
        </div>
        <div class="flex mt-4">
            <button class="btn btn-green-outline text-xs" @click="addOption"><i class="fas fa-plus mr-2"></i>Add option</button>
        </div>
        <div class="-mx-4 mt-4 px-4 pt-4 border-t flex justify-end">
            <button
                class="btn btn-gray-text"
                @click="proxyValue.required = !proxyValue.required"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.required"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Required
            </button>
            <button
                class="btn btn-gray-text"
                @click="proxyValue.random_order = !proxyValue.random_order"
            >
                <i class="far fa-circle mr-1" v-if="!proxyValue.random_order"></i>
                <i class="far fa-dot-circle text-green-400 mr-1" v-else></i>
                Shuffle options
            </button>
        </div>
    </div>
</template>

<script>
import FieldHeader from "./FieldHeader";

export default {
    name: "SelectionField",
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
        addOption() {
            this.proxyValue.options.push('New option');
            this.$nextTick(function () {
                this.$refs['options-container']
                    .lastChild
                    .querySelector('input')
                    .select();
            });
        },
        removeOption(index) {
            this.proxyValue.options.splice(index, 1);
        }
    }
}
</script>
