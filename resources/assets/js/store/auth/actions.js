import axios from 'axios'
import {NAME_TOKEN} from '../../config';
import {RESOURCE, COMMITS} from "./config";
import {COMMITS_ROOT} from "../utils/config";

export default {
    login({state, commit, dispatch}, params) {
        commit(COMMITS_ROOT.LOADING, true, {root: true});
        return new Promise((resolve, reject) => {
            axios.post(RESOURCE + 'login', params)
                .then(response => {
                    commit(COMMITS.LOGIN, {data : response.data.data, token: response.data.token});
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    resolve(response.data)

                })
                .catch(error => {
                    reject(error)
                })
                .finally(() => commit(COMMITS_ROOT.LOADING, false, {root: true}))
        });
    },
    checkLogin({state, commit}) {
        const token = localStorage.getItem(NAME_TOKEN);
        return new Promise((resolve, reject) => {
            if (!token) {
                commit(COMMITS.LOGOUT);
                return reject();
            }

            return axios.get(RESOURCE + 'me').then(response => {
                commit(COMMITS.LOGIN, {data : response.data.data, token: token});
                return resolve()
            }).catch(error => {
                commit(COMMITS.LOGOUT);
                return reject(error.response.data)
            });
        })
    },
    updateToken({commit}, token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
        commit(COMMITS.UPDATE_TOKEN, token)
    },
    updateStatus({commit}, status) {
        commit(COMMITS.UPDATE_AUTHENTICATED, status)
    },
    logout({commit}){
        return new Promise((resolve, reject) =>{
            commit(COMMITS.LOGOUT);
            resolve();
        })
    },
    editPerfil({state, commit}){
        commit(COMMITS_ROOT.LOADING, true, {root: true});
        return new Promise((resolve, reject) => {
            axios.put(RESOURCE + 'me', state.me)
                .then(response => {
                    commit(COMMITS.LOGIN, {data : response.data.data, token: response.data.token});
                    commit(COMMITS_ROOT.SHOW_TOAST, {text: 'Perfil atualizado com sucesso'}, {root: true});
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    resolve(response.data)

                })
                .catch(error => {
                    reject(error)
                })
                .finally(() => commit(COMMITS_ROOT.LOADING, false, {root: true}))
        });
    }
}


