<template>
  <div>
    <div class="mb-4">
      <label class="input-label">Name</label>
      <input type="text" class="input text-2xl" v-model="data.name">
    </div>
    <div class="mb-4">
      <label class="input-label">Description</label>
      <textarea class="input" rows="5" v-model="data.description"></textarea>
    </div>
    <component :is="wrappee" :project="project" v-model="form.fields"></component>
    <transition name="slide-fade">
      <div v-if="isDirty" class="fixed bottom-0 right-0 flex items-center justify-between p-4 bg-white w-full">
        <div class="container mx-auto">
          <button class="btn btn-green" @click="save">Save Form</button>
          <button class="btn btn-gray-text" @click="reset">Reset</button>
        </div>
        <div v-if="form.hasErrors()" class="text-red-600 text-xs">{{ form.firstError() }}</div>
      </div>
    </transition>
  </div>
</template>

<script>
import VrevalForm from "./VrevalForm";

export default {
  name: "BuilderWrapper",
  computed: {
    isDirty() {
      return this.form.isDirty();
    }
  },
  props: {
    project: {
      type: Object,
      required: true
    },
    wrappee: {
      type: String,
      required: true
    },
    data: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      form: new VrevalForm(this.data)
    }
  },
  methods: {
    save() {
      this.form.submit('/someendpoint');
    },
    reset() {
      this.form.reset();
    }
  }
}
</script>

<style>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}

.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-ade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */
{
  transform: translateY(60px);
  opacity: 0;
}
</style>
