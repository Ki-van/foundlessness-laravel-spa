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
            <ArticlePreview
                v-for="article in articles"
                :key="article.id"
                :article="article"
                :displayed-version="article.latest_public_version"
            />
        </div>
    </div>
</template>

<script>
import DomainPreview from "../components/DomainPreview";
import ArticlePreview from "../components/ArticlePreview";
import {mapActions} from "vuex";

export default {
    name: "Domain",
    data() {
        return {
            loading: true,
            articles: null,
            domain: {},
        }
    },
    methods: {
        ...mapActions({
            getArticles: 'article/getArticles',
            getDomain: 'article/getDomain'
        }),
        async init() {
            try {
                this.domain = await this.getDomain(this.$route.params.id);
                this.articles = (await this.getArticles()).filter(storedArticle => this.domain.articles.find(article => article.id === storedArticle.id));

                this.loading = false;
            } catch (e) {
                console.log(e);
                this.$router.push('/404');
            }
        }
    },
    computed: {},
    mounted() {
        this.init();
    },
    components: {DomainPreview, ArticlePreview}
}
</script>

<style scoped>

</style>
