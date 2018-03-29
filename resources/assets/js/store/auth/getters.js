export default {
    authenticated(state){ return state.authenticated},
    user(state){ return state.me},
    getToken(){return localStorage.getItem('token');}
}