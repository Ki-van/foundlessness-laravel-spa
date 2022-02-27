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
        <div v-show="stage === 1">
            <div class="block">
                <Editor class="art-post-content" @editorReady="editorReady"/>
                <button class="btn btn-dark p-2" @click="toSecondStage">Готов к публикации</button>
            </div>

        </div>
        <div v-show="this.stage === 2" class="block">
            <div class="block">
                <h2 class="art-post-header">
                    <img alt="CROSS" height="32" src="/images/cross.png" width="22">
                    <a href="#">
                        Настройки публикации
                    </a>
                </h2>
            </div>

            <ValidationObserver v-slot="{ handleSubmit }">
                <form class="container w-50" @submit.prevent="handleSubmit(createArticle)">
                    <div class="form-group ">
                        <ValidationProvider v-slot="{ errors }" rules="required">
                            <label for="heading">Заголовок</label>
                            <input id="heading" v-model="heading">
                            <span style="color: wheat">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>

                    <div class="form-group">
                        <ValidationProvider v-slot="{ errors }" rules="required|min:30">
                            <label for="descriptoin">Описание</label>
                            <textarea id="descriptoin" v-model="description"/>
                            <span style="color: wheat">{{ errors[0] || message }}</span>
                        </ValidationProvider>
                    </div>

                    <div class="form-group">
                        <div data-app>
                            <v-select v-model="selectedDomain"
                                      :items="domains"
                                      class="white--text white text--lighten-5"
                                      color="white"
                                      item-color="white"
                                      item-text="name"
                                      item-value="slug"
                                      label="Область знания"
                                      return-object
                                      single-line
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <div app-data>
                            <v-autocomplete
                                v-model="selectedTags"
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

                    <button class="btn btn-dark" type="submit">
                        <span v-show="!loading"> Отправить на модерацию  </span>
                        <span v-show="loading" aria-hidden="true" class="spinner-border spinner-border-sm"
                              role="status"></span>
                        <span v-show="loading" class="sr-only">Отправка...</span>
                    </button>

                </form>
            </ValidationObserver>
            <button class="btn btn-dark p-2" @click="stage = 1">Назад к публикации</button>
        </div>
    </div>
</template>

<script>
import Editor from "../components/Editor";
import {extend, ValidationObserver, ValidationProvider} from "vee-validate";
import {min, required} from "vee-validate/dist/rules";
import DataService from "../services/data.service";
import article from "./Article";

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
    data() {
        return {
            article: {},
            editor: null,
            stage: 1,
            heading: '',
            description: '',
            loading: false,
            message: '',
            domains: [],
            tags: [],
            selectedDomain: {},
            selectedTags: []
        }
    },
    watch: {
        heading: async function (newVal) {
            if (this.article.blocks[0].type === 'header') {
                let block = await this.editor.blocks.getBlockByIndex(0).save();
                this.editor.blocks.update(block.id, {text: newVal, level: block.data.level});
            }
        }
    },
    methods: {
        init() {
            DataService.getDomains().then(domains => {
                this.domains = domains;
                this.selectedDomain = domains[0];
            });
            DataService.getTags().then(tags => this.tags = tags);
        },
        toSecondStage() {
            this.stage = 2;
            this.editor.save().then((article) => {
                this.article = article;
                if (article.blocks[0].type === 'header') {
                    this.heading = article.blocks[0].data.text;
                }
            });
        },
        editorReady(editor) {
            this.editor = editor
        },
        async createArticle() {
            this.loading = true;
            try {
                let firstBlock = await this.editor.blocks.getBlockByIndex(0).save();
                if (firstBlock.tool === 'header') {
                    this.editor.blocks.delete(0);
                }
                this.article = await this.editor.save();

                await DataService.createArticle({
                    heading: this.heading,
                    description: this.description,
                    body: this.article,
                    domain_id: this.selectedDomain.id,
                    tags_id: this.selectedTags
                });

                this.$toasted.show("Отправлено на модерацию", {
                    theme: "toasted-primary",
                    position: "bottom-left",
                    duration: 1500
                });
                setTimeout(() => {
                    this.$router.push('/profile');
                }, 1500);
            } catch(error) {
                this.loading = false;

                console.error(error);
                this.$toasted.show("Не удалось создать публикацию(((", {
                    theme: "toasted-primary",
                    icon: 'error',
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
        Editor,
        ValidationProvider,
        ValidationObserver
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
