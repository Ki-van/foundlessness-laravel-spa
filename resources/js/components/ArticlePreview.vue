<template>
    <div class="block">
        <h2 class="art-post-header">
            <img src="images/cross.png" alt="CROSS" width="22" height="32">
            <router-link :to= "link">
               {{article.heading}}
            </router-link>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">{{article.created_at}}</span>
            |
            <a href="#" class="url">
                {{article.user.name}}
            </a>
        </div>
        <div class="art-post-content">
            <p>{{article.description}}</p>
        </div>
        <div class="art-postmetadatafooter">
            <span class="domain">
                Опубликовано в
            </span> <a class="url">{{article.domain.name}} </a>|
            <span class="tag">
                Теги
            </span>
            <template v-for="(tag, index) in article.tags">
                <a class="url">{{ tag.name }}</a>
                {{index === article.tags.length -1?'':', '}}
            </template>
        </div>
        <div class="art-post-evals-footer">
            <span class="domain">
                Оценка
            </span> <a class="url">{{marksSum}} </a>|
            <span class="domain">
                Комментарии
            </span> <a class="url">{{article.comments.length}} </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArticlePreview",
    props: ['article'],
    computed: {
        marksSum() {
            return this.article.marks.map((mark) => mark.value).reduce((partialSum, val) => partialSum + val, 0);
        },
        link(){
            return '/article/' + this.article.id;
        }
    }
}
</script>

<style scoped>



</style>
