import {RESOURCE, COMMITS_ROOT} from "./config";

export default {
    progressBar({dispatch}, status){
        dispatch(COMMITS_ROOT.PROGRESS_BAR, status);
        if(status === 100){
            setTimeout(()=>{
                dispatch(COMMITS_ROOT.PROGRESS_BAR, 0)
            }, 1000)
        }
    },
    showProgressBar({dispatch}, status){
        dispatch(COMMITS_ROOT.SHOW_PROGRESS_BAR, status);
    },
    setToast({commit}, toast){
        commit(COMMITS_ROOT.SHOW_TOAST, toast);
    },
    toogleToast({state, commit}){
        commit(COMMITS_ROOT.TOOGLE_TOAST);
    }
}


