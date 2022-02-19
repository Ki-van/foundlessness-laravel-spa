<template>
    <component :is="layout">

    </component>
</template>

<script>
import MainLayout from "../layouts/MainLayout";
export default {
    name: "Index",
    computed: {
        layout(){
            return (this.$route.meta.layout || 'main') + '-layout';
        }
    },
    components: {
        MainLayout
    }
}
</script>

<style scoped>

</style>
