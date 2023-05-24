import axios from "axios";
export default {
    actions: {
        getGroups(ctx, search) {
                axios
                    .get('data/groups',{
                        params: {
                            search: search
                        }
                    })
                    .then(res => {
                        ctx.commit('updateGroups', res.data)
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        deleteGroup(ctx, [search, id]) {
                axios
                    .post('data/groups/delete', {
                        itemId: id,
                        
                    })
                    .then(res => {
                        ctx.dispatch('getGroups', search);
                        ctx.commit('updateModal', [null, null, false])
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        editGroup(ctx, [search, id, value]){
            axios
            .post('data/groups/edit', {
                itemId: id,
                value: value,
            })
            .then(res => {
                ctx.dispatch('getGroups', search);
                ctx.commit('updateModalEdit', [null, null, false])
            })
            .catch(err => {
                console.log("Ошибка: " + err);
            }) 
        }
    },
    mutations: {
        updateGroups(state, data) {
            state.groups = data;
        },
    },
    state: {
        groups: [],       
    },
    getters: {
        groups(state) {
            return state.groups;
        },
    },

}