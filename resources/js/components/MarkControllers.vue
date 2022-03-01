<template>
    <div class="art-post-evals-footer" >
        <b-icon-chevron-up variant="info" @click="markHandler(1)"></b-icon-chevron-up>
        <span v-show="true" :class="{'mark-active': hasPositive}">{{ positiveMarks }}</span>
        <b-icon-chevron-down variant="danger" @click="markHandler(-1)"></b-icon-chevron-down>
        <span v-show="true" :class="{'mark-active': hasNegative}">{{ negativeMarks }}</span>
    </div>
</template>

<script>
import DataService from "../services/data.service";

export default {
    name: "MarkControllers",
    props: {
       markable: Object,
       markable_type: String,
    },
    data(){
        return {
            positiveMarks: 0,
            negativeMarks: 0,
            hasPositive: false,
            hasNegative: false,
            userId: null
        }
    },
    methods: {
        defineState() {
            this.positiveMarks = 0;
            this.negativeMarks = 0;
            this.hasPositive = false;
            this.hasNegative = false;
            this.ownMark_id = null;

            this.markable.marks.forEach((mark) => {
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

        async markHandler(value) {
            if(this.hasPositive && value === 1 || this.hasNegative && value === -1) {
                await DataService.deleteMark(this.ownMark_id)
                this.markable.marks = this.markable.marks.filter((mark) => mark.id !== this.ownMark_id);
            } else if(this.hasPositive && value === -1 ||this.hasNegative && value === 1 ) {
                const mark = DataService.updateMark(this.ownMark_id, value)
                this.markable.marks.find(mark => mark.id === this.ownMark_id).value = value;
            } else if(!this.hasNegative && !this.hasPositive){
                const mark = await DataService.createMark({
                    markable_type: this.markable_type,
                    markable_id: this.markable.id,
                    value: value
                });
                this.markable.marks.push(mark);
            }
            this.defineState()
        }
    },
    created() {
        if(this.$store.state.auth.status.loggedIn) {
            this.userId = this.$store.state.auth.user.id;
        }
        this.defineState();
    }
}
</script>

<style scoped>

</style>
