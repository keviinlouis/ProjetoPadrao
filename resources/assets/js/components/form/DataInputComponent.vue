<template>
    <v-layout>
        <v-flex>

            <v-menu
                    ref="openDataMenu"
                    lazy
                    :close-on-content-click="false"
                    v-model="openDataMenu"
                    transition="scale-transition"
                    offset-y
                    full-width
                    :nudge-right="40"
                    min-width="290px">
                <v-text-field
                        slot="activator"
                        label="Data"
                        type="text"
                        name="data"
                        v-model="data"
                        prepend-icon="event"
                        required
                        readonly
                        :error="!!error"
                />
                <v-date-picker
                        v-model="unformatedDate"
                        no-title scrollable
                        locale="pt-BR"
                        :allowed-dates="allowedDates"
                >
                    <v-spacer/>
                    <v-btn flat color="primary" @click="limparInput">Limpar</v-btn>
                    <v-btn flat color="primary" @click="openDataMenu = false">Cancelar</v-btn>
                    <v-btn flat color="primary" @click="$refs.openDataMenu.save(data)">OK</v-btn>
                </v-date-picker>
            </v-menu>
            <v-flex md12 sm12 xs12>
                <div class="input-group__details " v-if="error">
                    <div class="input-group__messages input-group__error input-error-image error--text">
                        {{error}}
                    </div>
                </div>
            </v-flex>
        </v-flex>
    </v-layout>
</template>

<script>
    import moment from 'moment'

    export default {
        name: "data-input-component",
        props: ['data', 'error'],
        data() {
            return {
                unformatedDate: null,
                formatedDate: null,
                openDataMenu: false
            }
        },
        methods: {
            allowedDates: val => {
                return moment().isBefore(val);
            },

            getDateFormated(str) {
                if (str != null) {
                    return str.substring(8, 10) + '/' + str.substring(5, 7) + '/' + str.substring(0, 4);
                }
                return '';
            },
            limparInput() {
                this.unformatedDate = null;
                this.openDataMenu = false;
            },
        },
        watch: {
            unformatedDate: function(val, oldVal){
                this.openDataMenu = false;
                this.$emit('dataUpdated', this.getDateFormated(val));
            },
            openDataMenu: function(val, oldVal){
                console.log(val, oldVal, this.unformatedDate);
                if(!val && oldVal && !this.unformatedDate){
                    this.$emit('errorDataUpdated', 'Escolha uma data para publicação');
                }else{
                    this.$emit('errorDataUpdated', false);
                }
            }
        },

    }
</script>

<style scoped>

</style>