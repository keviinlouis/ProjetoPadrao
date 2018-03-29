import Vue from 'vue'
import Vuex from 'vuex'

import utils from './utils'
import auth from './auth'
import dashboard from './dashboard'
import configuracoes from './configuracoes'
import atualidades from './atualidades'
import notificacoes from './notificacoes'
import anunciantes from './anunciantes'
import usuarios from './usuarios'
import animais from './animais'
import administradores from './administradores'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        utils: utils,
        auth: auth,
        dashboard: dashboard,
        configuracoes: configuracoes,
        atualidades: atualidades,
        notificacoes: notificacoes,
        anunciantes: anunciantes,
        usuarios: usuarios,
        animais: animais,
        administradores: administradores
    }

})