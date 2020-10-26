<template>
    <div>
        <div
            v-for="(field, index) in fields"
            :key="index"
            :class="field.type === 'section' ? 'mt-16 border-t-4 border-green-400' : ''"
            class="bg-white mb-4 rounded shadow p-4"
        >
            <component
                v-model="fields[index].template"
                :id="`${index}-${field.type}`"
                :is="`${field.type}-field`"
                :field-index="index"
                @down="down"
                @duplicate="duplicateField"
                @remove="removeField"
                @up="up"
            ></component>
        </div>

        <div class="mb-4 flex items-center">
            <span class="mr-4">Add field:</span>
            <button class="btn btn-gray-outline mx-2" @click="add('header')">Header</button>
            <button class="btn btn-gray-outline mx-2" @click="add('text')">Text</button>
            <button class="btn btn-gray-outline mx-2" @click="add('selection')">Selection</button>
            <button class="btn btn-gray-outline mx-2" @click="add('rating')">Rating</button>
            <button class="btn btn-gray-outline mx-2" @click="add('section')">New section</button>
        </div>
    </div>
</template>

<script>
import make from "./FieldFactory";
import HeaderField from "./HeaderField";
import TextField from "./TextField";
import RatingField from "./RatingField";
import SelectionField from "./SelectionField";
import SectionField from "./SectionField";

export default {
    name: "QuestionnaireBuilder",
    components: {
        HeaderField,
        TextField,
        RatingField,
        SelectionField,
        SectionField
    },
    props: {
        value: {
            type: Array,
            required: true
        }
    },
    computed: {
        fields: {
            get() { return this.value },
            set(newValue) { this.$emit('input', newValue) }
        }
    },
    methods: {
        duplicateField(index) {
            this.fields.splice(index, 0, JSON.parse(JSON.stringify(this.fields[index])));
        },
        removeField(index) {
            this.fields.splice(index, 1);
        },
        up(index) {
            const tmp = JSON.parse(JSON.stringify(this.fields[index]));
            this.removeField(index);
            this.fields.splice(index - 1, 0, tmp);
        },
        down(index) {
            const tmp = JSON.parse(JSON.stringify(this.fields[index]));
            this.removeField(index);
            this.fields.splice(index + 1, 0, tmp);
        },
        add(type) {
            this.fields.push(make(type))
        }
    }
}
</script>
