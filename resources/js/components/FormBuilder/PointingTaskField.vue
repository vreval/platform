<template>
    <div class="card mb-4">
        <div class="flex items-center justify-between">
            <h4 class="text-xs font-medium tracking-wider uppercase text-gray-600">Pointing Task</h4>
            <div class="flex">
                <button class="btn btn-icon ml-4" type="button" @click="$emit('remove')"><i
                    class="far fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PointingTaskField"
}
</script>
