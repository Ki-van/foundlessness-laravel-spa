<template>
    <div>
        <ArticlePreview v-for="article in articles" :key="article.id" :article="article" />
    </div>
</template>

<script>
import ArticlePreview from "../components/ArticlePreview";

export default {
    name: "Home",
    data(){
      return {
          articles: [],
        }
    },
    created() {
        this.initialize();
    },
    methods: {
     initialize(){
         this.$store.dispatch('article/getArticles').then(response => this.articles = response);
     },
    },
    components: {
        ArticlePreview
    }
}
</script>
