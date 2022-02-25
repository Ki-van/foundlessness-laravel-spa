<template>
    <component :is="layout">

    </component>
</template>

<script>
import MainLayout from "../layouts/MainLayout";
import EmptyLayout from "../layouts/EmptyLayout";
export default {
    name: "Index",
    computed: {
        layout(){
            return (this.$route.meta.layout || 'main') + '-layout';
        }
    },
    components: {
        MainLayout,
        EmptyLayout
    }
}
</script>

<style scoped>

</style>
