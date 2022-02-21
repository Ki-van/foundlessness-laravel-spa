<template>
    <div>
        <Header/>
        <div class="content">
            <Navbar/>
            <router-view/>
            <div class="block">
                <h2 class="art-post-header">
                    <img src="images/cross.png" alt="CROSS" width="22" height="32">
                    <a href="#">
                        Математическое доказательство судьбы
                    </a>
                </h2>
                <div class="art-post-header-meta">
                    <span>Опубликовано</span>
                    <span class="date">сегодня</span>
                    |
                    <a href="#" class="url">
                        Админом
                    </a>
                </div>
                <div class="art-post-content">
                    <p>
                        В основу доказательства положена информационная энтропия - мера неопределённости некоторой системы (в
                        статистической физике или теории информации). Попутно проведен ликбец по детерменизму.
                    </p>
                </div>
            </div>

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
