<template>
    <div>
        <div class="block" :class="{'own-comment': ownComment}">
            <div class="art-post-header-meta">
                <a class="url" href="#">
                    {{ comment.user.name }}
                </a> |
                <span class="date">
                    {{ comment.created_at }}
            </span>
            </div>
            <div class="art-post-content">
                {{ comment.body }}
            </div>

            <div class="d-inline-flex">
                <MarkControllers :markable_type="'Comment'" :markable="comment" />
                <div class="art-post-evals-footer">
                    <a class="url" @click="replayEvent">Ответить</a>
                </div>
            </div>
        </div>
        <div class="block" v-if="replayForm">
            <CommentForm @onSubmit="onCommentFormSubmit" :commented_id="comment.id"/>
        </div>
        <comment v-for="replay in comment.replies"
                 v-if="comment.replies && comment.replies.length"
                 :key="replay.id"
                 :comment="replay"
                 class="replay"
        />
    </div>
</template>

<script>
import DataService from "../services/data.service";
import CommentForm from "./CommentForm";
import MarkControllers from "./MarkControllers";

export default {
    name: "comment",
    data() {
        return {
            replayForm: false,
            positiveMarks: 0,
            negativeMarks: 0,
            hasPositive: false,
            hasNegative: false,
            ownMark_id: null,
            ownComment: false,
            userId: null
        }
    },
    props: {
        comment: Object
    },
    methods: {
        init() {

            this.positiveMarks = 0;
            this.negativeMarks = 0;
            this.hasPositive = false;
            this.hasNegative = false;
            this.ownMark_id = null;

            this.comment.marks.forEach((mark) => {
                mark.value > 0 ? ++this.positiveMarks : ++this.negativeMarks
                if(this.userId && this.userId === mark.user_id) {
                    this.ownMark_id = mark.id;
                    if (mark.value > 0)
                        this.hasPositive = true;
                    else
                        this.hasNegative = true;
                }
            });
        },
        replayEvent(){
            if(this.$can('create comments'))
                 this.replayForm = !this.replayForm;
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
        onCommentFormSubmit(newComment){
            this.replayForm = false;
            this.comment.replies.push(newComment);
        },
        markComment(value) {
            return DataService.createMark({
                markable_type: 'Comment',
                markable_id: this.comment.id,
                value: value
            })
        },
       async markHandler(value) {
            if(this.ownMark_id) {
               await DataService.deleteMark(this.ownMark_id)
                this.comment.marks = this.comment.marks.filter((mark) => mark.id !== this.ownMark_id);
            }

            if(this.hasPositive && value === -1 || this.hasNegative && value === 1 || !this.hasNegative && !this.hasPositive) {
                 const mark = await this.markComment(value);
                this.comment.marks.push(mark);
            }

            this.init()
        }
    },
    created() {
        if(this.$store.state.auth.status.loggedIn) {
            this.userId = this.$store.state.auth.user.id;
        }

    },
    mounted() {
        if(this.userId === this.comment.user?.id)
            this.ownComment = true;
        this.init();
    },
    components: {
        MarkControllers,
        CommentForm
    }
}
</script>

<style scoped>
.replay {
    margin-left: 40px;
    border-left: dotted;
}
.own-comment {
    border-color: lightslategray;
}
</style>
