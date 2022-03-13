<template>
    <div>
        <div class="block">
            <h2 class="art-post-header">
                <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                <a href="#">
                    Создание публикации
                </a>
            </h2>
            <div class="art-post-content">
                <h4>Если вы хотите стать частью ПСИХ, прочитайте текст ниже:</h4>
                <p>ПСИХ - уважаемая мной и организованное мной движение, участники которого ищущие люди, требующие от
                    себя
                    смотреть дальше своего носа. Целью движения не является коммерческая выгода, а чистый, идеальный
                    интерес.
                    Если вы прочитали Созерцание чистого разума и решили что познали истину, вам будут рады, но не у
                    нас) </p>
                <p>Участие в движении не предполагает авторизации, но так вы сможете называться своим именем и вас будет
                    легко
                    отличить от других участвующих.</p>
                <p>Если вы чувствуете, что можете дополнить картину надистины, прикрепите вашу статью в форме ниже и в
                    ходе
                    обсуждения мы найдем ей место на карта прогресса</p>
                <p>Пожалуйста, структурируйте ваши статьи, в потоке сознания искать иглу, что наркоману продеть нитку в
                    ту же
                    иглу, занятие интересное, но не для нас. (ДОЗУ)</p>
            </div>
        </div>
        <div v-if="baseVersion" v-show="stage === 1">
            <div class="block">
                <p class="art-post-content" v-if="displayBaseVersionVariants">
                    Базовая версия:
                    <VersionsDropdown :versions="inArticle.versions" :default="baseVersion" @input="onChangeVersion"/>
                </p>
                <Editor :article="baseVersion.body?baseVersion.body:null" class="art-post-content" @editorReady="editorReady" ref="Editor"/>
                <button class="btn btn-dark p-2" @click="toSecondStage">Готов к публикации</button>
            </div>

        </div>
        <div v-if="this.stage === 2" class="block">
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a href="#">
                        Настройки публикации
                    </a>
                </h2>
            </div>

            <ValidationObserver v-slot="{ handleSubmit }">
                <form class="container w-50" @submit.prevent="handleSubmit(submit)">
                    <div class="form-group ">
                        <ValidationProvider v-slot="{ errors }" rules="required">
                            <label for="heading">Заголовок</label>
                            <input id="heading" v-model="baseVersion.heading">
                            <span style="color: wheat">{{ errors[0] }}</span>
                        </ValidationProvider>
                        <span style="color: wheat" v-if="serverErrors">{{ serverErrors.heading ? serverErrors.heading[0] : '' }}</span>
                    </div>

                    <div class="form-group">
                        <ValidationProvider v-slot="{ errors }" rules="required|min:30">
                            <label for="description">Описание</label>
                            <textarea id="description" v-model="baseVersion.description"/>
                            <span style="color: wheat">{{ errors[0] || message }}</span>
                        </ValidationProvider>
                        <span style="color: wheat" v-if="serverErrors">{{ serverErrors.description ? serverErrors.description[0] : '' }}</span>
                    </div>


                    <div class="form-group">
                        <label for="domain">Область знания</label>
                        <b-form-select
                            id="domain"
                            v-model="selectedDomainId"
                            :options="domains"
                            class="w-100 mb-3 lg bg-dark text-white"
                            value-field="id"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>
                    </div>
                    <div class="form-group">
                        <div data-app>
                            <v-autocomplete
                                v-model="outArticle.tags"
                                :items="tags"
                                chips
                                dense
                                item-text="name"
                                item-value="id"
                                label="Теги"
                                multiple
                                small-chips
                                solo
                            ></v-autocomplete>
                        </div>
                    </div>

                    <div class="form-group" v-if="displayBaseVersionVariants">
                        <label for="semver">Тип версии</label>
                        <b-form-select
                            id="semver"
                            v-model="selectedVersionType"
                            :options="Array(
                                {
                                    name: 'Мажорная',
                                    value: 'major'
                                },
                                {
                                    name: 'Минорная',
                                    value: 'minor'
                                },
                                {
                                    name: 'Патч',
                                    value: 'patch'
                                })"
                            class="w-100 mb-1 lg bg-dark text-white"
                            value-field="value"
                            text-field="name"
                            disabled-field="notEnabled"
                        ></b-form-select>
                        <span class="art-post-evals-footer" style="color: white">
                            Следующая <a class="url">{{nextSemver}}</a>
                        </span>
                    </div>

                    <LoadingButton
                        class="mt-2"
                        :loading="loading"
                        :loading-text="'Отправка...'"
                        :text="'Отправить на модерацию'"
                        :type="'submit'"
                    />
                </form>
            </ValidationObserver>
            <button class="btn btn-dark p-2" @click="stage = 1">Назад к публикации</button>
        </div>
    </div>
</template>

<script>
import Editor from "../components/Editor";
import {extend} from "vee-validate";
import {required} from "vee-validate/dist/rules";
import DataService from "../services/data.service";
import {mapActions} from "vuex";
import {Article} from "../models/Article";
import LoadingButton from "../components/LoadingButton";
import VersionsDropdown from "../components/VersionsDropdown";
import {BFormSelect} from 'bootstrap-vue'
import {Semver} from "../models/Semver";
extend('required', {
    ...required,
    message: 'Поле {_field_} необходимо хоть чем-нибудь заполнить',
})
extend('min', {
    validate(value, {length}) {
        return value.length >= length;
    },
    params: ['length'],
    message: 'Минимум {length} символов'
});

export default {
    name: "Sandbox",
    props: {
        inArticle: {
            type: Object,
            default: null,
        },
        displayBaseVersionVariants: {
            type: Boolean,
            default: false,
        },
        serverErrors: {
            default: null,
        },
        created: Boolean
    },

    data() {
        return {
            outArticle: null,
            baseVersion: null,
            editor: null,
            stage: 1,
            loading: false,
            message: '',
            domains: [],
            tags: [],
            selectedDomainId: null,
            selectedVersionType: 'major'
        }
    },
    computed: {
      nextSemver: function () {
          if(this.displayBaseVersionVariants)
          {
              let semver = new Semver(this.outArticle.latest_version.semver);
              switch (this.selectedVersionType) {
                  case "major": semver.incrementMajor(); break;
                  case "minor": semver.incrementMinor(); break;
                  case "patch": semver.incrementPatch();break;
              }
              return semver.toString();
          } else
              return '1.0.0'
      }
    },
    watch: {
        heading: async function (newVal) {
            if (this.baseVersion.body.blocks[0].type === 'header') {
                let block = await this.editor.blocks.getBlockByIndex(0).save();
                this.editor.blocks.update(block.id, {text: newVal, level: block.data.level});
            }
        },
        created: function() {
            this.loading = false;
            this.$toasted.success("Публикация отправлена на модерацию", {
                theme: "toasted-primary",
                position: "bottom-left",
                duration: 3000
            });
            setTimeout( () => {
                this.$router.push('/profile')
            }, 3000);
        }
    },
    methods: {
        ...mapActions({
            getTags: 'article/getTags',
            getDomain: 'article/getDomains',
        }),
        async onChangeVersion(newVersion) {

            if(newVersion.id === this.inArticle.latest_public_version.id)
                this.baseVersion = this.inArticle.latest_public_version;
            else if (newVersion.id === this.inArticle.latest_version.id)
                this.baseVersion = this.inArticle.latest_version;
            else {
                this.loading = true;
                try {
                    this.baseVersion = await DataService.getVersion(newVersion.id);
                }catch (e) {
                    this.$toasted.show('Не удалось загрузить версию ' + newVersion.semver);
                }finally {
                    this.loading = false;
                }
            }
            this.$refs.Editor.reload();
        },
        setArticle(article) {
            if (article) {
                this.outArticle = article;
                this.baseVersion = article.latest_version;
            } else {
                this.outArticle = new Article(this.domains[0], [])
                this.baseVersion = this.outArticle.latest_version;
            }
            this.selectedDomainId=this.outArticle.domain.id;
        },
        async init() {
            this.domains = await DataService.getDomains();
            this.tags = await DataService.getTags();
            this.setArticle(this.inArticle);
        },
        toSecondStage() {
            this.stage = 2;
            this.editor.save().then((body) => {
                this.baseVersion.body = body;
                if (body.blocks[0].type === 'header') {
                    this.baseVersion.heading = body.blocks[0].data.text;
                }
            });
        },
        editorReady(editor) {
            this.editor = editor
        },
        async submit() {
            this.loading = true;

            try {
                let firstBlock = await this.editor.blocks.getBlockByIndex(0).save();
                if (firstBlock.tool === 'header') {
                    this.editor.blocks.delete(0);
                }
                this.baseVersion.body = await this.editor.save();

                this.$emit('create', {
                    domain_id: this.selectedDomainId,
                    tags_id: this.outArticle.tags,
                    version: {
                        heading: this.baseVersion.heading,
                        description: this.baseVersion.description,
                        body: this.baseVersion.body,
                        article_id: this.outArticle.id?this.outArticle.id:'',
                        version_type: this.selectedVersionType,
                    }
                });
            } catch (error) {
                this.loading = false;
                console.error(error);
                this.$toasted.show("Не удалось создать публикацию(((", {
                    theme: "toasted-primary",
                    position: "bottom-left",
                    duration: 3000
                });
            }
        }
    },
    mounted() {
        this.init();
    },
    components: {
        LoadingButton,
        Editor,
        VersionsDropdown,
        BFormSelect
    }
}
</script>

<style scoped>
.form-group input, textarea {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-dark-rgb), var(--bs-bg-opacity));
    --bs-text-opacity: 1;
    color: rgba(var(--bs-white-rgb), var(--bs-text-opacity));
    padding-right: 0.5rem !important;
    padding-left: 0.5rem !important;
    margin-top: 0.25rem !important;
    margin-bottom: 0.25rem !important;
    width: 100% !important;
}

.v-select__selection, .v-select__selection--comma {
    color: white !important;
}
</style>
