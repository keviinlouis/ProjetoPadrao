import actions from './actions';
import mutations from './mutators';
import getters from './getters';
import state from './state';

export default {
    namespaced: false,
    state: state,
    actions: actions,
    getters: getters,
    mutations: mutations
}