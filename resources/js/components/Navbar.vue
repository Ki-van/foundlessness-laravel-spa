<template>
    <nav>
        <ul class="nav">
            <li class="menu-item menu-item-active"><a href="/">Главная</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item"><a href="/domains">Области знаний</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item"><a href="#">Прогресс</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item"><a href="participation">Участие</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item">
                <div class="menu-dropdown">
                    <a href="../About.html">О ПСИХ</a>
                    <div class="menu-dropdown-content">
                        <a>О группе ПСИХ</a>
                        <a>FAQ</a>
                        <a>Карта сайта</a>
                    </div>
                </div>
            </li>

            <li><span class="menu-separator"></span></li>
            <li class="menu-item">
                <div class="menu-dropdown">
                    <a href="/admin">Admin</a>
                    <div class="menu-dropdown-content">
                        <a href="/admin/statistic">Статистика</a>
                        <a href="/admin/articles">Статьи</a>
                        <a>Комментарии</a>
                        <a>Пользователи</a>
                    </div>
                </div>
            </li>


            <li v-if="!loggedIn" class="menu-item push">
                <router-link to="/login">Вход</router-link>
            </li>
            <li v-if="!loggedIn"><span class="menu-separator"></span></li>
            <li v-if="!loggedIn" class="menu-item">
                <router-link to="/register">Регистрация</router-link>
            </li>


            <li class="menu-item push" v-if="loggedIn">
                <div class="menu-dropdown">
                    <router-link to="/profile">{{user.name}}</router-link>
                    <div class="menu-dropdown-content">
                        <a href="/profile/sandbox">Написать публикацию</a>
                        <a @click.prevent="logout">Выйти</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
        user() {
            return this.$store.state.auth.user;
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout').then(()=>{
                this.$router.push('/');
            });
        }
    }
}
</script>

<style scoped>

</style>
