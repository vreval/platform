<template>
  <component :is="wrappee" v-model="form.fields"></component>
</template>

<script>
import VrevalForm from "./VrevalForm";

export default {
  name: "BuilderWrapper",
  props: {
    wrappee: String,
    data: Array
  },
  data() {
    return {
      form: new VrevalForm({
        fields: this.data
      })
    }
  }
}
</script>
