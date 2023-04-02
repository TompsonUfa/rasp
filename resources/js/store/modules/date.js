export default {
    actions: {
        setActiveDate(ctx, date) {
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
        activeDate(state) {
            return state.date;
        },
    },
}
