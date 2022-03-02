<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
        <div v-if="!loading">
            <DomainPreview :domain="domain"/>
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a> Публикации </a>
                </h2>
            </div>
            <ArticlePreview v-for="article in articles" :key="article.id" :article="article" />
        </div>
    </div>
</template>

<script>
import DomainPreview from "../components/DomainPreview";
import ArticlePreview from "../components/ArticlePreview";
export default {
    name: "Domain",
    data(){
      return {
          loading: true,
          articles: null,
          domain: {},
      }
    },
    methods: {
      async init(){
          try {
              this.domain = await this.$store.dispatch('article/getDomain', this.$route.params.id);
              if(!this.$store.state.article.articles)
              {
                  await this.$store.dispatch('article/getArticles');
              }
              this.articles = this.$store.state.article.articles.filter(storedArticle => this.domain.articles.find(article=>article.id === storedArticle.id))
              this.loading = false;
          }catch (e) {
              console.log(e);
              this.$router.push('/404');
          }
      }
    },
    computed: {

    },
    mounted() {
        this.init();
    },
    components: {DomainPreview, ArticlePreview}
}
</script>

<style scoped>

</style>
