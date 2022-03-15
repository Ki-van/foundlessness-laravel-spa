<template>
    <div>
        <div class="block">
            <h2 class="art-post-header">
                <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                <a href="#">
                    Модерация
                </a>
            </h2>
            <div class="art-post-content">
                <h4>В этом разделе вы можете проверять публикации, находящихся на стадии модерации в доверенных вам областях</h4>
            </div>
        </div>
        <vue-title :title="displayedVersion?displayedVersion.heading: 'Публикация'"></vue-title>
        <Loading :loading="loading"/>
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
                    <span>Создано</span>
                    <span class="date">
                        {{ article.created_at }}
                    </span>
                    |
                    <a class="url" href="#">
                        {{ article.user.name }}
                    </a>
                    <span>
                            | Статус
                        </span>
                    <a class="url" href="#">
                        {{ displayedVersion.status.status }}
                    </a>
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
                <button class="btn btn-dark m-2" type="button" @click="publish">
                    <span v-show="!loading"> Опубликовать </span>
                    <span v-show="loading" aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span>
                    <span v-show="loading" class="sr-only">Публикация...</span>
                </button>
            </div>
        </template>
    </div>
</template>

<script>
import DataService from "../services/data.service";
import Editor from "../components/Editor";
import Loading from "../components/Loading";
import VersionsDropdown from "../components/VersionsDropdown";
import {mapActions} from "vuex";
import LoadingButton from "../components/LoadingButton";

export default {
    name: "Moderate",
    components: {
        LoadingButton,
        Loading,
        Editor,
        VersionsDropdown
    },
    data() {
        return {
            commentForm: false,
            article: null,
            displayedVersion: null,
            loading: true,
            editor: null,
            publishing: false,
        }
    },
    methods: {
        ...mapActions({
            getArticle: 'article/getToModerateArticle',
            publishVersion: 'article/moderateVersion',
        }),
        async publish(){
          try {
              this.publishing = true;
              await this.publishVersion(this.displayedVersion);
              this.$toasted.show('Статья опубликована', {
                  duration: 3000
              });
              setTimeout( () => {
                  this.$router.push('/profile/moderation')
              }, 3000);
          }catch (e){
              this.$toasted.show('Не удалось опубликовать версию((')
          }finally {
              this.publishing = false;
          }
        },
        editorReady(editor) {
            this.editor = editor;
        },
        async onChangeVersion(newVersion) {

            if (newVersion.id === this.article.latest_to_moderate_version.id)
                this.displayedVersion = this.article.latest_to_moderate_version;
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
            try {
                this.article = await this.getArticle(this.$route.params.id);
                this.displayedVersion = this.article.latest_to_moderate_version;
                this.loading = false;
            } catch (e) {
                this.$router.push('/404');
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
