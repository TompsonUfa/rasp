export default {
    actions: {
        openModalRemove(ctx, data) {
            ctx.commit('updateModal', [data.name, data.item, true])
        },
        closeModalRemove(ctx) {
            ctx.commit('updateModal', [null, null, false])
        }
    },
    mutations: {
        updateModal(state, [name, item, status]) {
            state.name = name;
            state.itemId = item ? item.id : null,
            state.itemName = item ? item.title : null;
            state.open = status;
        },
    },
    state: {
        name: null,
        itemId: null,
        itemName: null,
        open: false,
    },
    getters: {
        modalRemoveStatus(state) {
            return state.open;
        },
        modalRemoveData(state){
            return state;
        },
    },
}
