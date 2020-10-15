<template>
    <modal
        :classes="['modal']"
        :max-width="960"
        :shiftY="0.2"
        :width="'90%'"
        height="auto"
        name="new-checkpoint"
    >
        <h1 class="font-normal text-2xl mb-8">
            How to upload checkpoints
        </h1>

        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
            dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
            clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,
            consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
            sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no
            sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

        <div>
            <button class="btn btn-green" type="button" @click="$modal.hide('new-checkpoint')">Close</button>
        </div>
    </modal>
</template>

<script>
export default {
    name: "NewCheckpointModal",
    props: {
        project: {
            type: Object,
            required: true
        }
    }
}
</script>

