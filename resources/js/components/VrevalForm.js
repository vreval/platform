import jsonDiff from "json-diff";

export default class VrevalForm {
    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.submitted = false;
        this.errors = {};
    }

    data() {
        return Object.keys(this.originalData).reduce((data, attribute) => {
            data[attribute] = this[attribute];
            return data;
        }, {});
    }

    patch(endpoint) {
        if (!this.isDirty()) return;

        return this.submit(endpoint, "patch");
    }

    delete(endpoint) {
        return this.submit(endpoint, "delete");
    }

    post(endpoint) {
        return this.submit(endpoint);
    }

    submit(endpoint, requestType = "post") {
        return axios[requestType](endpoint, this.data())
            .then(this.onSuccess.bind(this))
            .catch(this.onFail.bind(this));
    }

    onSuccess(response) {
        this.submitted = true;
        this.errors = {};

        return response;
    }

    onFail(error) {
        this.submitted = false;

        this.errors = error.response.data.errors;

        throw error;
    }

    reset() {
        // Object.assign(this, this.originalData);
        this.errors = {};
        Object.assign(this, JSON.parse(JSON.stringify(this.originalData)));
    }

    hasErrors() {
        return Object.keys(this.errors).length > 0;
    }

    firstError() {
        return this.errors[Object.keys(this.errors)[0]][0];
    }

    isDirty() {
        return this.diff() !== undefined;
    }

    diff() {
       return jsonDiff.diff(this.originalData, this.data());
    }
}
