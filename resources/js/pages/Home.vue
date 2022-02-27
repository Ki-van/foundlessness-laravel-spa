<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
        <ArticlePreview v-for="article in articles" :key="article.id" :article="article" />
    </div>
</template>

<script>
import ArticlePreview from "../components/ArticlePreview";

export default {
    name: "Home",
    data(){
      return {
          loading: false,
          articles: [],
        }
    },
    created() {
        this.initialize();
    },
    methods: {
     initialize(){
         this.loading = true;
         this.$store.dispatch('article/getArticles').then(response => {
             this.loading = false;
             this.articles = response;
         });
     },
    },
    components: {
        ArticlePreview
    }
}
</script>
