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
    }
}
</script>

<style scoped>

</style>
