<template>
    <Sandbox
        v-if="article"
        @create="create"
        :server-errors="errors"
        :created="created"
        :in-article="article"
        :display-base-version-variants="true"
    />
</template>

<script>
import Sandbox from "./Sandbox";
import {mapActions} from "vuex";
export default {
    name: "AddVersion",
    components: {Sandbox},
    data() {
        return {
            article: null,
            created: false,
            errors: []
        };
    },

    methods: {
        ...mapActions({
           addVersion: 'article/addVersion',
           getArticle: 'article/getArticle',
        }),
        async init() {
            try {
                this.article = await this.getArticle(this.$route.params.id)
            }catch (e) {
                this.$router.push('/404');
            }

        },
        async create(article) {
            try {
                await this.addVersion(article.version);
                this.created = true;
            } catch(errors) {
                this.errors  = errors;
            }
        }
    },
    created() {
        this.init();
    }
}
</script>

<style scoped>

</style>
