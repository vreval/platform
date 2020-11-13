/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

String.prototype.ucFirst = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

Array.prototype.range = function (start, stop, step) {
    return Array.from({length: (stop - start) / step + 1}, (_, i) => start + (i * step));
}

require("./bootstrap");

window.Vue = require("vue");

import VModal from "vue-js-modal";

Vue.use(VModal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "new-project-modal",
    require("./components/NewProjectModal.vue").default
);
Vue.component(
    "new-scenario-modal",
    require("./components/NewScenarioModal").default
);
Vue.component(
    "new-checkpoint-modal",
    require("./components/NewCheckpointModal").default
);
Vue.component(
    "new-form-modal",
    require("./components/NewFormModal").default
);
Vue.component(
    "edit-project-modal",
    require("./components/EditProjectModal.vue").default
);
Vue.component(
    "edit-scenario-modal",
    require("./components/EditScenarioModal").default
);

Vue.component("modal-footer", require("./components/ModalFooter").default);
Vue.component("dropdown", require("./components/Dropdown.vue").default);
Vue.component("data-table", require("./components/Table.vue").default);
Vue.component("projects-table-row", require("./components/ProjectsTableRow.vue").default);
Vue.component("scenarios-table-row", require("./components/ScenariosTableRow.vue").default);
Vue.component("checkpoints-table-row", require("./components/CheckpointsTableRow.vue").default);
Vue.component("forms-table-row", require("./components/FormsTableRow.vue").default);

Vue.component("builder-wrapper", require("./components/BuilderWrapper").default);
Vue.component("scenario-builder", require("./components/ScenarioBuilder/ScenarioBuilder").default);
Vue.component("form-builder", require("./components/FormBuilder/FormBuilder").default);

Vue.component("questionnaire-builder", require("./components/FormBuilder/QuestionnaireBuilder").default);

Vue.component("tabs", require("./components/Tabs").default);
Vue.component("tab", require("./components/Tab").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    data() {
        return {
            projectsTableOptions: {
                orderBy: 'name',
                order: 'asc',
                headers: [
                    {text: 'Name', width: `${1 / 2 * 100}%`, name: 'name'},
                    {text: 'Created at', width: `${1 / 4 * 100}%`, name: 'formatted_created'},
                    {text: 'Updated at', width: `${1 / 4 * 100}%`, name: 'relative_updated'},
                ]
            },
            scenariosTableOptions: {
                orderBy: 'name',
                order: 'asc',
                headers: [
                    {text: 'Name', width: `${3 / 4 * 100}%`, name: 'name'},
                    {text: 'Checkpoints', width: `${1 / 4 * 100}%`, name: 'checkpoint_count'},
                ]
            },
            checkpointsTableOptions: {
                orderBy: 'name',
                order: 'asc',
                headers: [
                    {text: 'Name', width: `${1 / 2 * 100}%`, name: 'name'},
                    {text: 'Type', width: `${1 / 4 * 100}%`, name: 'checkpoint_count'},
                    {text: 'Behaviour', width: `${1 / 4 * 100}%`, name: 'checkpoint_count'},
                ]
            },
            formsTableOptions: {
                orderBy: 'name',
                order: 'asc',
                headers: [
                    {text: 'Name', width: `${3 / 4 * 100}%`, name: 'name'},
                    {text: 'Fields', width: `${1 / 4 * 100}%`, name: 'field_count'},
                ]
            }
        }
    }
});
