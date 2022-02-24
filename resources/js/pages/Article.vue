<template>

</template>

<script>
export default {
    name: "Article",
    computed: {
        id(){
            return this.$route.params.id
        }
    },
    mounted() {
        if(!id)
            this.$router.push('/404')
    }
}
</script>

<style scoped>

</style>
