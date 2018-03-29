<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm8 md6 lg4>
            <v-card class="elevation-12" color="transparent">
                <v-toolbar dark flat color="transparent" class="logo" height="222px" align-center justify-center>
                    <v-toolbar-title>
                        <img :src="logo" alt="logo"/>
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-text-field
                                prepend-icon="person"
                                label="Email"
                                type="text"
                                name="email"
                                id="email"
                                v-model="form.email"
                                v-validate="'required|email'"
                                :error-messages="errors.collect('email')"
                                required
                                @keyup.enter="login"
                        />
                        <v-text-field
                                prepend-icon="lock"
                                label="Senha"
                                type="password"
                                name="senha"
                                id="senha"
                                ref="senha"
                                v-model="form.senha"
                                v-validate="'required|min:6'"
                                :error-messages="errors.collect('senha')"
                                required
                                @keyup.enter="login"
                        />
                    </v-form>
                    <v-alert color="error" :value="loginFail">
                        {{errorLogin}}
                    </v-alert>
                    <a class="esqueci-senha">Esqueci a senha</a>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary"
                           block
                           :loading="loading"
                           @click.native="loader = 'loading'"
                           @click="login"
                           :disabled="loading">
                        Entrar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "login-component",
        data() {
            return {
                form: {
                    email: '',
                    senha: '',
                },
                trySubmitWithErrors: false,
                loginFail: false,
                errorLogin: ''
            }
        },
        computed: {
            ...mapGetters({
                loading: 'loading'
            }),
            logo() {
                return require('../../../images/logo.png')
            }
        },
        methods: {
            login() {
                this.resetLogin();
                this.$validator.validateAll().then((result) => {
                    if (!result) {
                        this.setError('Corrija os itens antes de continuar');
                        return false;
                    }
                    this.$store.dispatch('auth/login', this.form)
                        .then(() => this.$router.push({name: 'dashboard'}))
                        .catch((error) => this.setError(error.response.data.message))
                });
            },
            resetLogin() {
                this.loginFail = false;
                this.errorLogin = '';
                this.trySubmitWithErrors = false;
            },
            setError(error) {
                this.loginFail = true;
                this.errorLogin = error;
            }
        }
    }
</script>

<style scoped>
    .logo {
        height: 203px;
        margin-left: auto;
        margin-right: auto;
        width: 62%;
    }

    .logo img {
        height: 178px;
    }

    .esqueci-senha {
        text-align: center;
        width: 100%;
        display: block;
    }

    @media only screen and (min-width: 768px){
        .logo {
            width: 70%;
        }
    }
    @media only screen and (max-width: 767px){
        .logo {
            width: 86%;
        }
    }

    @media only screen and (max-width: 424px){
        .logo {
            width: 100%;
        }
    }
</style>