export default {
    actions: {
        setDate(ctx, date) {
            ctx.commit('updateDate', date)
        }
    },
    mutations: {
        updateDate(state, date) {
            state.date = date;
        },
    },
    state: {
        date: {},
    },
    getters: {
        date(state) {
            return state.date;
        },
    },
}
