<template>
    <div class="block">
        <h2 class="art-post-header d-flex justify-content-between">
            <div>
                <img src="/images/cross.png" alt="CROSS" width="22" height="32">
                <router-link :to= "link">
                    {{displayedVersion.heading}}
                </router-link>
            </div>
            <div v-if="displayVersionUp && (article.user.id === user.id || $can('manage', 'all'))">
                <router-link :to="String('/profile/sandbox/' + article.id)">
                    <b-icon-box-arrow-up-right style="color: white" />
                </router-link>
            </div>
        </h2>
        <div class="art-post-header-meta">
            <span>Опубликовано</span>
            <span class="date">{{displayedVersion.created_at}}</span>
            |
            <a href="#" class="url">
                {{article.user.name}}
            </a>
        </div>
        <div class="art-post-content">
            <p>{{displayedVersion.description}}</p>
        </div>
        <div class="art-postmetadatafooter">
            <span class="domain">
                Опубликовано в
            </span> <router-link class="url" :to="String('/domains/' + article.domain.id)">{{article.domain.name}} </router-link>
            <template v-if="article.tags.length > 0">
                |
                <span class="tag">
                    Теги
                </span>
                <template v-for="(tag, index) in article.tags">
                    <a class="url">{{ tag.name }}</a>
                    {{index === article.tags.length -1?'':', '}}
                </template>
            </template>
            <template v-if="displayedVersion.status.id !== 1">
                |
                <span class="tag">
                    Статус
                </span>
                <a class="url">{{displayedVersion.status.status}}</a>
            </template>
        </div>
        <div class="art-post-evals-footer d-flex justify-content-between">
            <div>
                <span class="domain">
                    Оценка
                </span> <a class="url">{{marksSum}} </a>|
                <span class="domain">
                    Комментарии
                </span> <a class="url">{{commentsTotal}} </a>
            </div>
            <div>
               <b-icon-journals style="color: white"/>
                <a class="url">{{displayedVersion.semver}} </a>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    name: "ArticlePreview",
    props: {
        article: Object,
        displayVersionUp: {
            type: Boolean,
            default: false
        },
        displayedVersion: Object,
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        marksSum() {
            return this.displayedVersion.marks.reduce((partialSum, mark) => partialSum + mark.value, 0);
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
            if(this.displayedVersion.comments[0] && this.displayedVersion.comments[0].replies) {
                return this.displayedVersion.comments.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment), 0)
            } else
                return this.displayedVersion.comments.length;
        }
    }
}
</script>

<style scoped>



</style>
