export default {
  props: {
    collapsed: Boolean
  },
  mounted() {
    this.open(this.fieldIndex);
  },
  methods: {
    open(index) {
      this.$emit('open', index);
    }
  }
}
