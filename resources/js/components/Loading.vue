<template>
    <div v-if="loading" class="d-flex justify-content-center">
    <div class="spinner-border" role="status">
    </div>
    </div>
</template>

<script>
export default {
    name: "Loading",
    props:['loading']
}
</script>

<style scoped>

</style>
