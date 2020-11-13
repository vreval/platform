export default {
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
        // add(type) {
        //     this.fields.push(make(type))
        // }
    }
}