export default {
    actions: {
        setSearch(ctx, search) {
           ctx.commit('updateSearch', search)
        },
    },
    mutations: {
        updateSearch(state, search) {
            state.search = search;
        },
    },
    state: {
        search: "",       
    },
    getters: {
        search(state) {
            return state.search;
        },
    },

}