<template>
    <div>
        <vue-title :title="displayedVersion?displayedVersion.heading: 'Публикация'"></vue-title>
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
        <template v-if="article && displayedVersion">
            <div class="block">
                <div class="d-flex justify-content-between align-items-end">
                    <h2 class="art-post-header  ">
                        <div>
                            <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                            <a>
                                {{ displayedVersion.heading }}
                            </a>
                        </div>
                    </h2>
                    <VersionsDropdown :default="displayedVersion" :versions="article.versions"
                                      @input="onChangeVersion"/>
                </div>
                <div class="art-post-header-meta">
                    <span>Опубликовано</span>
                    <span class="date">
                        {{ article.created_at }}
                    </span>
                    |
                    <a class="url" href="#">
                        {{ article.user.name }}
                    </a>
                    <template v-if="displayedVersion.status.id !== 1">
                        <span>
                            | Статус
                        </span>
                        <a class="url" href="#">
                            {{ displayedVersion.status.status }}
                        </a>
                    </template>
                </div>
            </div>
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a>Описание</a>
                </h2>
                <p class="art-post-content">{{ displayedVersion.description }}</p>
            </div>
            <div class="block">
                <Editor ref="Editor" :article="displayedVersion.body" :readonly="true" class="art-post-content"
                        @editorReady="editorReady"/>
                <div class="d-inline-flex ">
                    <MarkControllers :markable="displayedVersion" :markable_type="'Version'"/>
                    <div class="art-post-evals-footer">
                        <a class="url" @click="commentFormEventHandler">Комментировать</a>
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
            <div v-if="commentForm" class="block">
                <CommentForm :commentable_id="displayedVersion.id" :commentable_type="'Version'"
                             @onSubmit="onCommentFormSubmit"/>
            </div>
            <CommentsSection :comments="displayedVersion.comments"/>
        </template>
    </div>
</template>

<script>
import Editor from "../components/Editor";
import CommentsSection from "../components/CommentsSection";
import MarkControllers from "../components/MarkControllers";
import CommentForm from "../components/CommentForm";
import VersionsDropdown from "../components/VersionsDropdown";
import DataService from "../services/data.service";

export default {
    name: "Article",
    components: {
        VersionsDropdown,
        CommentForm,
        MarkControllers,
        Editor,
        CommentsSection
    },
    data() {
        return {
            commentForm: false,
            article: null,
            displayedVersion: null,
            loading: false,
            editor: null,
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
            if (this.displayedVersion.comments)
                return this.displayedVersion.comments.reduce((partialTotal, currentComment) => partialTotal + counter(currentComment), 0)
            else
                return 0;
        }
    },
    methods: {
        commentFormEventHandler(){
            if(this.$can('create comments'))
                this.commentForm = !this.commentForm;
            else {
                if(!this.userId)
                    this.$toasted.show('Чтобы оставить комментарий нужно себя обозначить(0((', {
                        theme: "toasted-primary",
                        position: "bottom-left",
                        duration: 3000
                    });
                else
                    this.$toasted.show('Тебе запрещено оставлять комментарии(((', {
                        theme: "toasted-primary",
                        position: "bottom-left",
                        duration: 3000
                    });
            }
        },
        onCommentFormSubmit(newComment) {
            this.commentForm = false;
            this.displayedVersion.comments.push(newComment);
        },
        editorReady(editor) {
            this.editor = editor;
        },
        async onChangeVersion(newVersion) {

            if (newVersion.id === this.article.latest_public_version.id)
                this.displayedVersion = this.article.latest_public_version;
            else {
                this.loading = true;
                try {
                    this.displayedVersion = await DataService.getVersion(newVersion.id);
                } catch (e) {
                    this.$toasted.show('Не удалось загрузить версию ' + newVersion.semver);
                } finally {
                    this.loading = false;
                }
            }
            this.$refs.Editor.reload();
        },
        async init() {
            this.loading = true;
            this.$store.dispatch('article/getArticle', this.$route.params.id)
                .then(article => {
                    console.log()
                    this.article = article
                    this.displayedVersion = this.article.latest_public_version ? this.article.latest_public_version : this.article.latest_version;
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
