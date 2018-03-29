<template>
   <div>
   <v-navigation-drawer fixed v-model="drawer" class="transition-drawer" :width="259" app style="z-index: 2147483646">
       <v-list dense>
           <v-list-tile class="logo">

               <img :src="require('../../../images/logo.png')" alt="logo" />

           </v-list-tile>

           <v-list-tile v-for="menu in menus" :key="menu.title" @click="menu.isLink ? routerPush(menu.url) : null">

               <v-list-tile-action>

                   <v-icon :class="{'active': isInRoute(menu.url)}" v-if="menu.icon_material">{{menu.icon_material}}</v-icon>

                   <side-bar-icon v-else-if="menu.icon" v-bind:icon="menu.icon" :alt="menu.title" />

               </v-list-tile-action>

               <v-list-tile-content>

                   <v-list-tile-title :class="{'active':isInRoute(menu.url)}">{{menu.title}}</v-list-tile-title>

               </v-list-tile-content>

           </v-list-tile>

       </v-list>

   </v-navigation-drawer>

   <v-toolbar color="white" fixed app :class="{'drawer-open':drawer}" style="z-index: 2147483645">

       <v-toolbar-side-icon @click.stop="drawer = !drawer"/>

       <v-toolbar-title >PetLovers</v-toolbar-title>

       <v-spacer/>

       <v-avatar size="35px" class="hidden-sm-and-down">

           <img :src="foto_perfil">

       </v-avatar>

       <v-menu >

           <v-btn slot="activator" flat>

              Admin <v-icon>keyboard_arrow_down</v-icon>

           </v-btn>
           <v-list>

               <v-list-tile v-for="action in actions" :key="action.title" @click="action.func? action.func() : null">

                   <v-list-tile-action>

                       <v-icon>{{action.icon}}</v-icon>

                   </v-list-tile-action>

                   <v-list-tile-content>

                       <v-list-tile-title>{{action.title}}</v-list-tile-title>

                   </v-list-tile-content>

               </v-list-tile>

           </v-list>

       </v-menu>

   </v-toolbar>

   </div>
</template>

<script>
    import SibeBarIcon from './SideBarIcon'

    export default {
        components: {
            'side-bar-icon': SibeBarIcon
        },
        name: "base-page",
        computed: {
            foto_perfil: () => {
                return require('../../../images/imagem-perfil.jpg')
            }
        },
        data(){
            return {
                drawer: false,
                actions: [
                    {
                        title: 'Minha Conta',
                        icon: 'create',
                        func: this.meRoute,
                        master: false
                    },
                    {
                        title: 'Administradores',
                        icon: 'person_add',
                        func: this.routerPushAdmin,
                        master: true
                    },
                    {
                        title: 'Sair',
                        icon: 'input',
                        func: this.logout,
                        master:false
                    }
                ],
                menus: [
                    {
                        title: 'Dashboard',
                        url: 'dashboard',
                        icon: 'dashboard',
                        icon_material: 'home',
                        isLink: true,
                        sub: false
                    },
                    {
                        title: 'Usuários Cadastrados',
                        url: 'usuarios',
                        icon: 'usuarios-cadastrados',
                        icon_material: 'person',
                        isLink: true,
                        sub: true
                    },
                    {
                        title: 'Pets no mercado',
                        url: 'pets-mercado',
                        icon: 'pets-mercado',
                        icon_material: 'store',
                        isLink: true,
                        sub: true
                    },
                    {
                        title: 'Pets no perdidos',
                        url: 'pets-perdidos',
                        icon: 'pets-perdidos',
                        icon_material: 'help_outline',
                        isLink: true,
                        sub: true
                    },
                    {
                        title: 'Pets para doação',
                        url: 'pets-doacoes',
                        icon: 'pets-doacao',
                        icon_material: 'fa-paw',
                        isLink: true,
                        sub: true
                    },
                    {
                        title: 'Configurações de Planos',
                        url: 'configuracoes',
                        icon: 'configuracoes-planos',
                        icon_material: 'settings',
                        isLink: true,
                        sub: false
                    },
                    {
                        title: 'Atualidades',
                        url: 'atualidades',
                        icon: 'atualidades',
                        icon_material: 'library_books',
                        isLink: true,
                        sub: false
                    },
                    {
                        title: 'Notificações',
                        url: 'notificacoes',
                        icon: 'notificacoes',
                        icon_material: 'notifications_none',
                        isLink: true,
                        sub: false
                    },
                    {
                        title: 'Anunciantes',
                        url: 'anunciantes',
                        icon: 'anunciantes',
                        icon_material: 'credit_card',
                        isLink: true,
                        sub: false
                    }

                ]
            }
        },
        methods:{
            logout(){
                this.$store.dispatch('auth/logout').then(() =>{
                    this.$router.push({name: 'login'})
                })
            },
            routerPush(url){
                if(url !== '#' && url.length) {
                    this.$router.push({name: url})
                }
                if(this.isMobile()){
                    this.drawer = false;
                }
            },
            routerPushAdmin(){
                this.routerPush('administradores')
            },
            isMobile(){
                return this.$vuetify.breakpoint.width < 1264;
            },
            isInRoute(route){
                return this.$route.name === route;
            },
            meRoute(){
                this.$router.push({name: 'perfil'})
            }

        },
        created(){
            this.drawer = !this.isMobile();
        }

    }
</script>

<style scoped>
    .logo {
        height: 88px;
        margin-top: 32px;
    }
    .logo img {
        height: 85px;
        display: block;
        margin-left: 18%;
    }
    .transition-drawer{
        transition: .3s;
        padding: 0;
    }

    .drawer-open{
        padding-left: 259px !important;
    }

    .active{
        color: #d0021b;
    }
</style>