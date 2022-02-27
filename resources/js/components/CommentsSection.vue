<template>
    <div>
        <Comment v-for="comment in comments" :comment="comment" :key="comment.id" class="mt-2"/>
    </div>
</template>

<script>
import Comment from "./Comment";
export default {
    name: "CommentsSection",
    props:{
        comments: Array
    },
    components: {
        Comment
    }
}
</script>

<style scoped>

</style>
