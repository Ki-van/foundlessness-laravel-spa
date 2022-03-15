<template>
    <div>
        <div class="block">
            <h2 class="art-post-header">
                <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                <a href="#">
                    Модерация
                </a>
            </h2>
            <div class="art-post-content">
                <h4>В этом разделе вы можете проверять публикации, находящихся на стадии модерации в доверенных вам областях</h4>
            </div>
        </div>
        <Loading :loading="loading" />
        <article-preview
            v-if="!loading"
            v-for="article in articles"
            :key="article.id" :article="article"
            :displayed-version="article.latest_to_moderate_version"
            :propsLink="String('/profile/moderation/'+article.id)"
        />
    </div>
</template>

<script>
import DomainPreview from "../components/DomainPreview";
import ArticlePreview from "../components/ArticlePreview";
import Loading from "../components/Loading";
import DataService from "../services/data.service";
export default {
    name: "Moderation",
    components: {Loading, ArticlePreview, DomainPreview},
    data(){
        return {
            loading: true,
            articles: null,
        }
    },
    methods: {
      async init(){
          this.articles = await DataService.getModeratedArticles()
          this.loading = false;
      }
    },
    computed: {
        domains(){
            return this.$store.state.article.domains;
        },

    },
    created() {
        this.init()
    }
}
</script>

<style scoped>

</style>
