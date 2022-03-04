<template>
    <nav>
        <ul class="nav">
            <li class="menu-item" :class="{'menu-item-active': $route.matched[0].name === 'home'}">
                <router-link :to="{name: 'home'}">Главная</router-link>
            </li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item" :class="{'menu-item-active': $route.matched[0].name.startsWith('domains')}">
                <router-link :to="{name: 'domains'}" >Области знаний</router-link>
            </li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item"><a href="#">Прогресс</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item"><a href="">Участие</a></li>
            <li><span class="menu-separator"></span></li>
            <li class="menu-item" :class="{'menu-item-active': $route.matched[0].name === 'about'}">
                <router-link :to="{name: 'about'}">О ПСИХ</router-link>
            </li>
<!--            <li><span class="menu-separator"></span></li>
            <li class="menu-item">
                <div class="menu-dropdown">
                    <a href="../About.html">О ПСИХ</a>
                    <div class="menu-dropdown-content">
                        <a>О группе ПСИХ</a>
                        <a>FAQ</a>
                        <a>Карта сайта</a>
                    </div>
                </div>
            </li>-->

            <li><span class="menu-separator" v-if="$can('manage', 'all')"></span></li>
            <li class="menu-item" v-if="$can('manage', 'all')">
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


            <li v-if="!loggedIn" class="menu-item push" :class="{'menu-item-active': $route.matched[0].name === 'login'}">
                <router-link to="/login">Вход</router-link>
            </li>
            <li v-if="!loggedIn"><span class="menu-separator"></span></li>
            <li v-if="!loggedIn" class="menu-item" :class="{'menu-item-active': $route.matched[0].name === 'register'}">
                <router-link to="/register">Регистрация</router-link>
            </li>


            <li class="menu-item push" v-if="loggedIn" :class="{'menu-item-active': $route.matched[0].name.startsWith('profile')}">
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
