<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
        <div v-if="article" class="block">
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a>
                        {{ article.heading }}
                    </a>
                </h2>
                <div class="art-post-header-meta">
                    <span>Опубликовано</span>
                    <span class="date">
                    {{ article.created_at }}
                </span>
                    |
                    <a class="url" href="#">
                        {{ article.user.name }}
                    </a>
                </div>
            </div>
            <div class="block">
                <Editor :article="article" :readonly="true"/>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from "../components/Editor";
import DataService from "../services/data.service";

export default {
    name: "Article",
    components: {Editor},
    data() {
        return {
            article: null,
            loading: false,
        }
    },
    methods: {
        async init() {
            this.loading = true;
            this.$store.dispatch('article/getArticle', this.$route.params.id)
                .then(article => {
                    console.log()
                    this.article = article
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error)
                    this.$router.push('/404')
                });
        }
    },
    created() {
        this.init();
    }
}
</script>

<style scoped>

</style>
