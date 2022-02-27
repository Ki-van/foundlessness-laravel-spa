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
            </span> <a class="url">{{commentsTotal}} </a>
        </div>
    </div>
</template>

<script>
import {article} from "../store/article.module";

export default {
    name: "ArticlePreview",
    props: ['article'],
    computed: {
        marksSum() {
            return this.article.marks.reduce((partialSum, mark) => partialSum + mark.value, 0);
        },
        link(){
            return '/article/' + this.article.id;
        },
        commentsTotal() {
            let counter = (comment) => {

                    if (comment.replies.lenght === 0)
                        return 1;
                    else {
                        return comment.replies.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment) + 1, 0)
                    }

            };
            if(this.article.comments[0] && this.article.comments[0].replies) {
                return this.article.comments.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment), 0)
            } else
                return this.article.comments.length;
        }
    }
}
</script>

<style scoped>



</style>
