<template>
    <button class="btn btn-dark" :type="type">
        <span v-show="!loading"> {{ text }}  </span>
        <span v-show="loading" aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span>
        <span v-show="loading" class="sr-only">{{ loadingText }}</span>
    </button>
</template>

<script>
export default {
    name: "LoadingButton",
    props: {
        type: {
            type: String,
            default: 'submit'
        },
        loading: Boolean,
        text: {
            type: String,
            default: 'Отправить'
        },
        loadingText: {
            type: String,
            default: 'Отправка'
        }
    }
}
</script>

<style scoped>

</style>
