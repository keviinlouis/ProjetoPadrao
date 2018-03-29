<template>
    <v-card>
        <v-container fluid>
            <v-layout row wrap pt-3 pl-2>
                <v-flex md12 pb-3>
                    <h2>Editar Perfil</h2>
                    <v-divider/>
                </v-flex>
                <v-flex md6 sm12 xs12 pr-3 mb-5 style="border-right: 1px solid #c7c2c2;">
                    <v-layout row wrap>
                        <v-flex md12 sm12 xs12>
                            <upload-input
                                    ref="uploadInput"
                                    v-on:imageUpdated="updateImage"
                                    :removeFoto="true"
                                    v-model="administrador.path_perfil"
                                    :loadImage="administrador.url_foto_perfil"
                                    :height_imagem="200"
                                    :width_imagem="200"
                                    name="imagem"
                            />
                        </v-flex>
                        <v-flex md12 sm12 xs12>
                            <v-text-field
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    v-model="administrador.nome"
                                    v-validate="'required'"
                                    @key.enter="validaInput()"
                                    :error-messages="errors.has('nome')?errors.first('nome'):[]"/>
                        </v-flex>
                        <v-flex md12 sm12 xs12>
                            <v-text-field
                                    label="Email"
                                    name="email"
                                    type="text"
                                    v-model="administrador.email"
                                    v-validate="'required'"
                                    @key.enter="validaInput()"
                                    :error-messages="errors.has('email')?errors.first('email'):[]"/>
                        </v-flex>

                        <v-flex md12 sm12 xs12>
                            <v-text-field
                                    label="Senha Antiga"
                                    name="senha"
                                    type="text"
                                    v-model="administrador.senha"
                                    v-validate="'min:6'"
                                    @key.enter="validaInput()"
                                    :error-messages="errors.has('senha')?errors.first('senha'):[]"/>
                        </v-flex>
                        <v-flex md12 sm12 xs12>
                            <v-text-field
                                    label="Senha Nova"
                                    name="nova_senha"
                                    type="text"
                                    v-model="administrador.nova_senha"
                                    v-validate="'min:6|confirmed:nova_senha_confirmation'"
                                    @key.enter="validaInput()"
                                    :error-messages="errors.has('nova_senha')?errors.first('nova_senha'):[]"/>
                        </v-flex>
                        <v-flex md12 sm12 xs12>
                            <v-text-field
                                    label="Confirmar Senha Nova"
                                    name="nova_senha_confirmation"
                                    type="text"
                                    v-model="administrador.nova_senha_confirmation"
                                    v-validate="'min:6'"
                                    @key.enter="validaInput()"
                                    :error-messages="errors.has('nova_senha_confirmation')?errors.first('nova_senha_confirmation'):[]"/>
                        </v-flex>

                        <v-flex md12>
                            <v-layout row>
                                <v-flex md6 pr-3>
                                    <v-btn
                                            color="default"
                                            class="btn-enviar"
                                            block
                                            @click="routerBack()">
                                        Voltar
                                    </v-btn>
                                </v-flex>
                                <v-flex md6 pl-3>
                                    <v-btn
                                            color="primary"
                                            class="btn-enviar"
                                            :disabled="loading"
                                            :loading="loading"
                                            block
                                            @click.native="loader = loading"
                                            @click="validaInput()">
                                        Salvar
                                        <span slot="loading" class="custom-loader">
                                    <v-icon light>cached</v-icon>
                                </span>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import UploadFotoComponent from '../form/UploadFotoComponent'
    import estadosCidades from '../../estados-cidades.json'
    import AwesomeMask from 'awesome-mask'

    export default {
        directives: {
            'mask': AwesomeMask
        },
        name: "administrador-component",
        components: {
            'upload-input': UploadFotoComponent
        },
        data() {
            return {
                imagem_nova: ''
            }
        },
        methods: {
            ...mapActions({
                editAdministrador: 'auth/editPerfil'
            }),
            updateImage({nome}) {
                this.administrador.path_perfil = nome;
            },
            routerBack() {
                this.$router.back()
            },
            validaInput() {
                this.$validator.validateAll().then(result => {
                    if (!result) {
                        return;
                    }
                    this.editAdministrador();
                })
            }
        },
        computed: {
            ...mapGetters({
                loading: 'loading',
                administrador: 'auth/user'
            })
        },
        created() {

        }
    }
</script>

<style scoped>

</style>