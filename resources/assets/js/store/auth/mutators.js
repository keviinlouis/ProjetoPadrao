import {NAME_TOKEN} from '../../config';

export default {
    login(state, {data, token}) {
        localStorage.setItem(NAME_TOKEN, token);
        state.token = token;
        state.me = data;
        state.authenticated = true;
    },
    logout(state) {
        localStorage.removeItem(NAME_TOKEN);

        state.token = null;
        state.me = {};
        state.authenticated = false;
    },
    setToken(state, token) {
        localStorage.setItem(NAME_TOKEN, token);
        state.token = token;
    },
    setUser(state, user) {
        state.me = user;
    },
    setAuthenticated(state, status) {
        state.authenticated = status;
    }
};