<template>
    <ValidationObserver v-slot="{ invalid }">
        <form class="container w-50" @submit.prevent="register">
            <div class="form-group">
                <ValidationProvider v-slot="{ errors }" rules="alpha_num|required">
                    <label for="name">Имя</label>
                    <input id="name" v-model="name">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
                <span style="color: wheat" v-if="serverErrors">{{ serverErrors.name ? serverErrors.name[0] : '' }}</span>
            </div>
            <div class="form-group ">
                <ValidationProvider v-slot="{ errors }" rules="email|required">
                    <label for="email">Почта</label>
                    <input id="email" v-model="email">
                    <span style="color: wheat">
                        {{ errors[0] }}
                    </span>
                </ValidationProvider>
                <span style="color: wheat" v-if="serverErrors">{{ serverErrors.email ? serverErrors.email[0] : '' }}</span>
            </div>
            <div class="form-group">
                <ValidationProvider v-slot="{ errors }" rules="min:6|required">
                    <label for="password">Пароль</label>
                    <input id="password" v-model="password" type="password">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="form-group">
                <ValidationProvider v-slot="{ errors }" :rules="{is: password}">
                    <label for="password_confirm">Подтверждение пароля</label>
                    <input id="password_confirm" v-model="password_confirmation" type="password">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <LoadingButton :disabled="invalid" :loading="loading" :loading-text="'Регистрация...'"
                           :text="'Зарегистрироваться'" :type="'submit'"/>
        </form>
    </ValidationObserver>
</template>

<script>
import {extend} from "vee-validate";
import {required, email, alpha_num, min, is} from 'vee-validate/dist/rules';
import LoadingButton from "../components/LoadingButton";

extend('email', {
    ...email,
    message: 'Не похоже',
})
extend('required', {
    ...required,
    message: 'Поле пусто',
})
extend('is', {
    ...is,
    message: 'Пароли не совпадают',
})
extend('alpha_num', {
    ...alpha_num,
    message: 'Используйте только буквы и цифры',
})
extend('min', {
    validate(value, {length}) {
        return value.length >= length;
    },
    params: ['length'],
    message: 'Минимум {length} символов'
});

export default {
    name: "Register",
    components: {LoadingButton},
    data() {
        return {
            loading: false,
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            serverErrors: {}
        }
    },
    methods: {
       async register() {
            this.loading = true;
            try {
                const response = await this.$store.dispatch('auth/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });
                console.log('Response register success: ', response);

                this.$toasted.show("Регистрация прошла успешно", {
                    theme: "toasted-primary",
                    position: "bottom-left",
                    duration: 1500
                });
                setTimeout(() => {
                    this.$router.push('/login');
                }, 1500);
            }catch (error){
                this.serverErrors = error.errors;
            }finally {
                this.loading = false
            }
        }
    }
}
</script>

<style scoped>
input {
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
