<template>
    <div>
        <Header/>
        <div class="content">
            <Navbar/>
            <router-view/>
            <Footer/>
        </div>
    </div>
</template>

<script>
import Header from "../components/Header";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer"
export default {
    name: "MainLayout",
    components: {
        Header,
        Navbar,
        Footer
    },
    mounted() {
        if(this.$store.state.auth.status.loggedIn)
        {

        }
    }
}
</script>

<style scoped>

</style>
