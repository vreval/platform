const templates = {
    header() {
        return {
            "type": "header",
            "template": {
                "text": "",
                "show_subtitle": true,
                "subtitle": ""
            }
        }
    },
    text() {
        return {
            "type": "text",
            "template": {
                "text": ""
            }
        }
    },
    selection() {
        return {
            "type": "selection",
            "template": {
                "question": "",
                "subtitle": "",
                "options": [
                    "Option 1",
                    "Option 2",
                    "Option 3",
                ],
                "selection": 0,
                "random_order": false,
                "dropdown": false,
                "show_subtitle": false,
                "required": false,
                "multiple_choice": false
            }
        }
    },
    rating() {
        return {
            "type": "rating",
            "template": {
                "question": "",
                "subtitle": "",
                "levels": 5,
                "items": [
                    {
                        "lower_bound_label": "Label",
                        "upper_bound_label": "Label",
                    }
                ],
                "show_subtitle": false,
                "required": false,
                "show_labels": true
            }
        }
    },
    section() {
        return {
            "type": "section",
            "template": []
        }
    }
};

export default function make(type) {
    return templates[type]();
}
