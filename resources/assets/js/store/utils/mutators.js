import {COMMITS_ROOT} from './config'

export default {
    [COMMITS_ROOT.LOADING]: (state, isLoading) => {
        state.loading = isLoading;
    },
    [COMMITS_ROOT.PROGRESS_BAR]: (state, status) => {
        state.progressBar = status;
    },
    [COMMITS_ROOT.SHOW_PROGRESS_BAR]: (state, status) => {
        state.showProgressBar = status;
    },
    [COMMITS_ROOT.SHOW_TOAST]: (state, toast) => {
        state.toast.text = toast.text;
        state.toast.tempo = toast.tempo?toast.tempo:6000;
        state.toast.show = true;
        switch(toast.direction){
            case 'top-left':
                state.toast.top = true;
                state.toast.bottom = false;
                state.toast.left = true;
                state.toast.right = false;
                break;
            case 'top-right':
                state.toast.top = true;
                state.toast.bottom = false;
                state.toast.left = false;
                state.toast.right = true;
                break;
            case 'bottom-left':
                state.toast.top = false;
                state.toast.bottom = true;
                state.toast.left = true;
                state.toast.right = false;
                break;
            case 'bottom-right':
                state.toast.top = false;
                state.toast.bottom = true;
                state.toast.left = false;
                state.toast.right = true;
                break;
            default:
                state.toast.top = false;
                state.toast.bottom = true;
                state.toast.left = false;
                state.toast.right = true;
        }
    },
    [COMMITS_ROOT.TOOGLE_TOAST]: (state) => {
        state.toast.show = !state.toast.show;
    }

};