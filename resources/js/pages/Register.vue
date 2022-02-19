<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <form class="container w-50" @submit.prevent="handleSubmit(register)">
            <div class="form-group">
                <ValidationProvider rules="alpha_num|required" v-slot="{ errors }">
                    <label for="name">Имя</label>
                    <input v-model="name"  id="name">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="form-group ">
                <ValidationProvider rules="email|required" v-slot="{ errors }">
                    <label for="email">Почта</label>
                    <input v-model="email" id="email">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="form-group">
                <ValidationProvider rules="min:6|required" v-slot="{ errors }">
                    <label for="password">Пароль</label>
                    <input type="password" v-model="password" id="password">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="form-group">
                <ValidationProvider rules="is:password|required" v-slot="{ errors }">
                    <label for="password_confirm">Пароль</label>
                    <input type="password" v-model="password_confirm"  id="password_confirm">
                    <span style="color: wheat">{{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </ValidationObserver>
</template>

<script>
import {extend, ValidationObserver, ValidationProvider} from "vee-validate";
import {required, email, alpha_num, min, is} from 'vee-validate/dist/rules';

extend('email', {
    ...email,
    message: 'Не похоже',
})
extend('required', {
    ...required,
    message: 'Поле {_field_} пусто',
})
extend('alpha_num', {
    ...alpha_num,
    message: 'Только буквы и цифры',
})
extend('min', {
    validate(value, { length }) {
        return value.length >= length;
    },
    params: ['length'],
    message: 'Поле {_field_} должно быть как минимум {length} символов'
});

export default {
    name: "Register",
    components: {
      ValidationObserver,
      ValidationProvider
    },
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirm: "",
            error: null
        }
    },
    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/login"
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    }
}
</script>

<style scoped>
input {
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
