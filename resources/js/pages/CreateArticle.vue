<template>
    <Sandbox @create="create" :server-errors="errors" :created="created" />
</template>

<script>
import Sandbox from "./Sandbox";
import {mapActions} from "vuex";

export default {
    name: "CreateArticle",
    components: {Sandbox},
    data() {
        return {
            article: null,
            created: false,
            errors: {}
        };
    },
    methods: {
        ...mapActions({
            createArticle: 'article/createArticle'
        }),
        async create(article) {
            try {
               await this.createArticle(article);
               this.created = true;
            } catch(errors) {
                this.errors  = errors.errors;
            }
        }
    }
}
</script>

<style scoped>

</style>
