import LoginComponent from '../components/auth/LoginComponent';
import PageNotFoundComponent from './../components/layout/PageNotFoundComponent';

export default [
    /**
     * Rotas Admin
     */
    {
        path: '/admin/entrar',
        component: LoginComponent,
        name: 'login',
        meta: {
            auth: false
        }
    },
    {
        path: '/admin/404',
        component: PageNotFoundComponent,
        name: '404'
    },

]