const settings = {
    annotation() {
        return {
            type_name: 'annotation'
        }
    },
    pointing() {
        return {
            type_name: 'pointing'
        }
    },
    placing() {
        return {
            type_name: 'placing'

        }
    },
    questionnaire() {
        return {
            type_name: 'questionnaire'

        }
    },
    wayfinding() {
        return {
            type_name: 'wayfinding'

        }
    }
};

export default function make(type) {
    return settings[type]();
}
