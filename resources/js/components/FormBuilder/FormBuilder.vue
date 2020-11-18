<template>
  <div>
    <questionnaire-builder v-model="form.fields"></questionnaire-builder>
    <transition name="slide-fade">
      <div v-if="isDirty"
           class="fixed bottom-0 right-0 flex items-center justify-between p-4 bg-white rounded-tl-lg shadow">
        <div>
          <button class="btn btn-green" @click="save">Save Form</button>
          <button class="btn btn-gray-text" @click="reset">Reset</button>
        </div>
        <div v-if="form.hasErrors()" class="text-red-600 text-xs">{{ form.firstError() }}</div>
      </div>
    </transition>
  </div>
</template>

<script>
import VrevalForm from "../VrevalForm";


export default {
  name: "FormBuilder",
  props: {
    initialForm: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      form: new VrevalForm(this.initialForm),
      task: new VrevalForm(this.initialForm.task || {type: 'none'}),
      error: {},
      isSubmitting: false
    }
  },
  computed: {
    isDirty() {
      return this.form.isDirty();
    },
    projectPath() {
      return `/projects/${this.initialForm.project_id}`;
    },
    formPath() {
      return `${this.projectPath}/forms/${this.initialForm.id}`;
    }
  },
  methods: {
    tabName(name, form) {
      return (form.isDirty() ? '(!) ' : '') + name;
    },
    save() {
      this.isSubmitting = true;
      const formRequest = this.form.patch(this.formPath);
      const taskRequest = this.task.patch(this.formPath + '/task');

      axios.all([formRequest, taskRequest])
          .then(axios.spread((...responses) => {
            // const [formResponse, taskResponse] = responses;
            // console.log(formResponse);
            // console.log(taskResponse);
            location = this.formPath;
          }))
          .catch(errors => console.log(errors));
    },
    reset() {
      this.form.reset();
      this.task.reset();
    },
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

.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */
{
  transform: translateX(30px);
  opacity: 0;
}
</style>
