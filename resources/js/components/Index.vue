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
            console.log('Route matched',this.$route.matched);
            return (this.$route.meta.layout || this.$route.matched[0].meta.layout || 'main') + '-layout';
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
