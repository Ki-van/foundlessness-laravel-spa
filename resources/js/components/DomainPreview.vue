<template>
    <div class="block">
        <h2 class="art-post-header">
            <img src="/images/cross.png" alt="CROSS" width="22" height="32">
            <router-link :to= "link">
                {{domain.name}}
            </router-link>
        </h2>
        <div class="art-post-content">
            <p>{{domain.description}}</p>
        </div>
        <div class="art-post-evals-footer">
            <span class="domain">
                Статей:
            </span> <a class="url">{{domain.articles.length?domain.articles.length: 'Нет'}} </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "DomainPreview",
    props: {
        domain: Object,
    },
    computed: {
        link(){
            return '/domains/' + this.domain.id;
        }
    },
}
</script>

<style scoped>

</style>
