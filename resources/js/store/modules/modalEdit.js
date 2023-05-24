export default {
    actions: {
        openModalEdit(ctx, data) {
            ctx.commit('updateModalEdit',  [data.name, data.item, true])
        },
        closeModalEdit(ctx) {
            ctx.commit('updateModalEdit', [null, null, false])
        }
    },
    mutations: {
        updateModalEdit(state, [name, item, status]) {
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
        modalEditStatus(state) {
            return state.open;
        },
        modalEditData(state){
            return state;
        },
    },
}
