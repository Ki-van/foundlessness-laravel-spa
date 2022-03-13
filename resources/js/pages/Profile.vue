<template>
    <div>
        <div class="block">
            <h2 class="art-post-header">
                <img src="/images/cross.png" alt="CROSS" width="22" height="32">
                <a class="url" href="">
                    {{user.name}}
                </a>
            </h2>

        </div>
        <div class="block">
            <h2 class="art-post-header">
                <img src="/images/cross.png" alt="CROSS" width="22" height="32">
                <a class="url" href="">
                    Публикации
                </a>
            </h2>
        </div>
        <ArticlePreview
            v-for="article in user.articles"
            :article="article"
            :key="article.id"
            :display-version-up="true"
            :displayed-version="article.latest_public_version?article.latest_public_version: article.latest_version"
        />
        <vue-title :title="user.name"></vue-title>
    </div>
</template>
<script>
import ArticlePreview from "../components/ArticlePreview";
export default {
    name: 'Profile',
    components: {ArticlePreview},
    computed: {
        user() {
            return this.$store.state.auth.user;
        }
    },
    mounted() {
        if (!this.user) {
            this.$router.push('/login');
        }
    }
};
</script>
