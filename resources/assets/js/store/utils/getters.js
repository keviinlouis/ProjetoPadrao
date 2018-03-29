import {GETTERS_ROOT} from './config'

export default {
    [GETTERS_ROOT.LOADING]: (state) => state.loading,
    [GETTERS_ROOT.PROGRESS_BAR]: (state) => state.progressBar,
    [GETTERS_ROOT.SHOW_PROGRESS_BAR]: (state) => state.showProgressBar,
    [GETTERS_ROOT.GET_TOAST]: (state) => state.toast,
}