<template>
    <div>
        <div
            v-for="(field, index) in form.fields"
            :key="index"
            :class="field.type === 'section' ? 'mt-16 border-t-4 border-green-400' : ''"
            class="bg-white mb-4 rounded shadow p-4"
        >
            <component
                v-model="form.fields[index].template"
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
        <div class="sticky bottom-0 flex items-center justify-between p-4 bg-white rounded shadow">
            <div>
                <button class="btn btn-green" @click="save">Save form</button>
                <button class="btn btn-gray-text" @click="reset">Reset</button>
            </div>
            <span class="text-red-600" v-if="form.hasErrors()">Could not save; Form has errors:{{ form.errors[Object.keys(form.errors)[0]][0] }}</span>
        </div>
    </div>
</template>

<script>
import VrevalForm from "../VrevalForm";
import make from "./FieldFactory";
import HeaderField from "./HeaderField";
import TextField from "./TextField";
import RatingField from "./RatingField";
import SelectionField from "./SelectionField";
import SectionField from "./SectionField";

export default {
    name: "ProjectFormBuilder",
    components: {
        HeaderField,
        TextField,
        RatingField,
        SelectionField,
        SectionField
    },
    props: {
        initialForm: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: new VrevalForm(this.initialForm)
        }
    },
    computed: {
        formPath() {
            return `/projects/${this.initialForm.project_id}/forms/${this.initialForm.id}`;
        }
    },
    methods: {
        save() {
            this.form.patch(this.formPath)
                .then(response => (location = this.formPath));
        },
        reset() {
            this.form.reset();
        },
        duplicateField(index) {
            this.form.fields.splice(index, 0, JSON.parse(JSON.stringify(this.form.fields[index])));
        },
        removeField(index) {
            this.form.fields.splice(index, 1);
        },
        up(index) {
            const tmp = JSON.parse(JSON.stringify(this.form.fields[index]));
            this.removeField(index);
            this.form.fields.splice(index - 1, 0, tmp);
        },
        down(index) {
            const tmp = JSON.parse(JSON.stringify(this.form.fields[index]));
            this.removeField(index);
            this.form.fields.splice(index + 1, 0, tmp);
        },
        add(type) {
            this.form.fields.push(make(type))
        }
    }
}
</script>
