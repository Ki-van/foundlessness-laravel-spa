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
         axios.get('/api/article').then(response => {
             this.articles = response.data.data;
             console.debug('Articles', this.articles)
         });
     },
    },
    components: {
        ArticlePreview
    }
}
</script>
