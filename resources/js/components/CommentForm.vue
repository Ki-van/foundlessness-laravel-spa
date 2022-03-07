<template>
    <ValidationObserver ref="form" v-slot="{ handleSubmit }">
        <form @submit.prevent="handleSubmit(onSubmit)" >
            <div class="form-group ">
                <ValidationProvider name="Comment" rules="required"  v-slot="{ errors }">
                    <textarea v-model="replayBody" />
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <LoadingButton :loading="loading" :type="'submit'"/>
        </form>
    </ValidationObserver>
</template>

<script>
import LoadingButton from "./LoadingButton";
import {required} from "vee-validate/dist/rules";
import {extend} from "vee-validate";
import DataService from "../services/data.service";

extend('required', {
    ...required,
    message: 'Не оставляйте поле пустыми',
})

export default {
    name: "CommentForm",
    data(){
      return {
          replayBody: '',
          loading: false,
      }
    },
    methods: {
      onSubmit(){
            this.loading = true;
            let comment = {
                body: this.replayBody
            };

            if(this.commented_id) {
                comment.comment_id = this.commented_id;
            }
            else
            {
                comment.commentable_type = this.commentable_type;
                comment.commentable_id = this.commentable_id;
            }
            DataService.createComment(comment).then((createdComment)=>{
                this.loading = false;
                console.log('Created comment', createdComment);
                this.$emit('onSubmit', createdComment);
            }).catch(()=>this.$toasted.show('Комментарий создать не удалось((('));
      }
    },
    props: {
      commented_id: {
          type: Number,
          default: null,
      },
      commentable_type: {
        type: String,
        default: 'Comment'
      },
      commentable_id: {
          type: Number,
      },
    },
    components: {
        LoadingButton
    }
}
</script>

<style scoped>
.form-group textarea {
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
</style>
