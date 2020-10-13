<template>
    <data-table use-filter :headers="tableHeaders" :content="formattedProjects"></data-table>
</template>

<script>
export default {
    name: "ProjectsTable",
    props: {
        projects: {
            type: Array,
            required: true
        }
    },
    computed: {
        formattedProjects () {
            return this.projects.map(project => ({
                name: project.name,
                created_at: project.formatted_created,
                updated_at: project.relative_updated,
                isPinned: project.is_pinned,
                id: project.id
            }))
        }
    },
    data() {
        return {
            tableHeaders: [
                { text: "Name", fieldName: 'name', width: `${1/2 * 100}%` },
                { text: "Created at", fieldName: 'created_at', width: `${1/4 * 100}%` },
                { text: "Updated at", fieldName: 'updated_at', width: `${1/4 * 100}%` }
            ]
        }
    }
}
</script>
