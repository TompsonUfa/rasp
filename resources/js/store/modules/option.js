export default {
    actions: {
        setActive(ctx, option) {
            ctx.commit('updateOption', option)
        }
    },
    mutations: {
        updateOption(state, option) {
            state.option = option;
        },
    },
    state: {
        option: {},
    },
    getters: {
        activeOption(state) {
            return state.option;
        },
    },
}
