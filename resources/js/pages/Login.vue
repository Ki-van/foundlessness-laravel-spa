<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <form class="container w-50" @submit.prevent="handleSubmit(onSubmit)">
            <div class="form-group ">
                <ValidationProvider rules="email|required" v-slot="{ errors }">
                    <label for="email">Почта</label>
                    <input v-model="auth.email"  id="email">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <ValidationProvider rules="required" v-slot="{ errors }">
                    <label for="password">Пароль</label>
                    <input type="password" v-model="auth.password"  id="password">
                    <span style="color: wheat">{{ errors[0] || message}}</span>
                </ValidationProvider>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Запомнить меня</label>
            </div>
            <button type="submit" class="btn btn-dark">
                <span v-show="!loading"> Войти  </span>
                <span v-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-show="loading"  class="sr-only">Вход...</span>
            </button>

        </form>
    </ValidationObserver>
</template>

<script>
import {required, email} from 'vee-validate/dist/rules'
import {extend} from "vee-validate";
import {mapActions} from 'vuex';

extend('email', {
    ...email,
    message: 'Не похоже',
})
extend('required', {
    ...required,
    message: 'Поле {_field_} пусто',
})
export default {
    name: "Login",
    data() {
        return {
            auth: {
                email: "",
                password: "",
            },
            loading: false,
            message: ""
        }
    },
    methods: {
        ...mapActions({
            login:'auth/login'
        }),
        async onSubmit() {
            this.loading = true;
            try {
                const user = await this.login(this.auth)
                let rules = [];
                if (user.roles[0].name === 'Admin')
                    rules = [{subject: 'all', action: 'manage'}];
                else
                    rules = [{subject: 'all', actions: user.roles.map((rule) => rule.permissons).join()}];
                this.$ability.update(rules);
                this.$router.push('/profile');
            }catch(e) {
                this.message = e;
            }finally {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>
.form-group input {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));
    --bs-text-opacity: 1;
    color: rgba(var(--bs-white-rgb),var(--bs-text-opacity));
    padding-right: 0.5rem!important;
    padding-left: 0.5rem!important;
    margin-top: 0.25rem!important;
    margin-bottom: 0.25rem!important;
    width: 100%!important;
}
</style>
