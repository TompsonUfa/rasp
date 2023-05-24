import axios from "axios";
export default {
    actions: {
        getCategories(ctx, search) {
                axios
                    .get('data/categories',{
                        params: {
                            search: search
                        }
                    })
                    .then(res => {
                        ctx.commit('updateCategory', res.data)
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        deleteCategory(ctx, [search, id]) {
                axios
                    .post('data/categories/delete', {
                        itemId: id,
                    })
                    .then(res => {
                        ctx.dispatch('getCategories', search);
                        ctx.commit('updateModal', [null, null, false])
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        editCategory(ctx, [search, id, value]){
            axios
            .post('data/categories/edit', {
                itemId: id,
                value: value,
            })
            .then(res => {
                ctx.dispatch('getCategories', search);
                ctx.commit('updateModalEdit', [null, null, false])
            })
            .catch(err => {
                console.log("Ошибка: " + err);
            }) 
        }
    },
    mutations: {
        updateCategory(state, data) {
            state.categories = data;
        },
    },
    state: {
        categories: [],       
    },
    getters: {
        categories(state) {
            return state.categories;
        },
    },

}