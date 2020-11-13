<template>
  <div>
    <div
        v-for="(field, index) in fields"
        :key="index"
        :class="field.type === 'section' ? 'mt-16 border-t-4 border-green-400' : ''"
        class="bg-white mb-4 rounded shadow p-4"
    >
      <component
          :is="`${field.type}-field`"
          :id="`${index}-${field.type}`"
          v-model="fields[index].template"
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
import make from "./FormFieldFactory";
import BuilderFieldsMixin from "../BuilderFieldsMixin";
import HeaderField from "./HeaderField";
import TextField from "./TextField";
import RatingField from "./RatingField";
import SelectionField from "./SelectionField";
import SectionField from "./SectionField";

export default {
  name: "QuestionnaireBuilder",
  mixins: [
    BuilderFieldsMixin
  ],
  components: {
    HeaderField,
    TextField,
    RatingField,
    SelectionField,
    SectionField
  },
  methods: {
    add(type) {
      this.fields.push(make(type))
    }
  }
}
</script>
