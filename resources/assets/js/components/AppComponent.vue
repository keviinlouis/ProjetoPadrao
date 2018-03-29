<template>
    <v-app id="inspire" :class="{'background-login': isInLogin}">
        <div class="progressBar" v-show="showProgressBar" style="z-index: 2147483647">
            <v-progress-linear v-model="progressBar" color="black"/>
        </div>
        <base-page v-if="authenticated"/>
        <v-content :class="{'background-app': !isInLogin}" >
            <v-container :class="{'fluid fill-height': isInLogin}">
                <router-view/>
            </v-container>
        </v-content>
        <v-snackbar
                :timeout="toast.timeout"
                :top="toast.top"
                :bottom="toast.bottom"
                :right="toast.right"
                :left="toast.left"
                v-model="toast.show"
        >
            {{ toast.text }}
            <v-btn flat color="red" @click.native="toogleToast">Fechar</v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
    import BasePageComponent from './layout/BasePageComponent';
    import {mapGetters, mapActions} from 'vuex';
    export default {
        name: "app-component",
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                progressBar: 'progressBar',
                showProgressBar: 'showProgressBar',
                toast: 'getToast'
            }),
            isInLogin(){
                return this.$route.name === 'login';
            }
        },
        methods:{
            ...mapActions({
                toogleToast: 'toogleToast'
            })
        },
        components:{
            'base-page': BasePageComponent
        }
    }
</script>

<style>
    .background-login {
        background-size: cover !important;
        background: url('/assets/images/login-bg.png') no-repeat !important;
    }
    .progressBar{
        z-index: 999999;
        margin-top: -14px;
        position: absolute;
        top: 0;
        width: 100%;
        left: 0;
    }
    .background-app {
        background: lightgray !important;
    }

    @media only screen and (min-width: 1024px){
        .container {
            max-width: 1332px !important;
        }
        .background-app {
            padding: 65px 0 0 260px
        }

    }

    @media only screen and (max-width: 1024px){
        .background-app {
            padding: 65px 0 0 0 !important
        }
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px;

    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }



</style>