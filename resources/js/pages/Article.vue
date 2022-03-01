<template>
    <div>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
        <template v-if="article">
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a>
                        {{ article.heading }}
                    </a>
                </h2>
                <div class="art-post-header-meta">
                    <span>Опубликовано</span>
                    <span class="date">
                    {{ article.created_at }}
                </span>
                    |
                    <a class="url" href="#">
                        {{ article.user.name }}
                    </a>
                </div>
            </div>
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a>Описание</a>
                </h2>
                <p class="art-post-content">{{ article.description }}</p>
            </div>
            <div class="block">
                <Editor :article="article" :readonly="true" class="art-post-content" @editorReady="editorReady"/>
                <div class="d-inline-flex ">
                        <MarkControllers :markable="article" :markable_type="'Article'"/>
                    <div class="art-post-evals-footer">
                        <a class="url" @click="commentForm = !commentForm">Комментировать</a>
                    </div>
                </div>
            </div>
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a> Комментарии
                        <a class="url" style="color: #FFE852">{{ commentsTotal ? commentsTotal : '' }}</a>
                    </a>
                </h2>
            </div>
            <div class="block" v-if="commentForm">
                <CommentForm @onSubmit="onCommentFormSubmit" :commented_id="article.id"/>
            </div>
            <CommentsSection :comments="article.comments"/>
        </template>
    </div>
</template>

<script>
import Editor from "../components/Editor";
import CommentsSection from "../components/CommentsSection";
import MarkControllers from "../components/MarkControllers";
import CommentForm from "../components/CommentForm";

export default {
    name: "Article",
    components: {
        CommentForm,
        MarkControllers,
        Editor,
        CommentsSection
    },
    data() {
        return {
            commentForm: false,
            article: null,
            loading: false,
            editor: null
        }
    },
    computed: {
        commentsTotal() {
            let counter = (comment) => {
                if (!comment.replies || comment.replies.length === 0)
                    return 1;
                else {
                    return comment.replies.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment) + 1, 0)
                }
            };
            return this.article.comments.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment), 0)
        }
    },
    methods: {
        onCommentFormSubmit(newComment){
            this.commentForm = false;
            this.article.comments.push(newComment);
        },
        editorReady(editor) {
            this.editor = editor;
        },
        async init() {
            this.loading = true;
            this.$store.dispatch('article/getArticle', this.$route.params.id)
                .then(article => {
                    console.log()
                    this.article = article
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error)
                    this.$router.push('/404')
                });
        }
    },
    created() {
        this.init();
    }
}
</script>

<style scoped>

</style>
