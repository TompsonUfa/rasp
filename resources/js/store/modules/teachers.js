import axios from "axios";
export default {
    actions: {
        getTeachers(ctx, search) {
                axios
                    .get('data/teachers',{
                        params: {
                            search: search
                        }
                    })
                    .then(res => {
                        ctx.commit('updateTeachers', res.data)
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        deleteTeacher(ctx, [search, id]) {
                axios
                    .post('data/teachers/delete', {
                        itemId: id,
                    })
                    .then(res => {
                        ctx.dispatch('getTeachers', search);
                        ctx.commit('updateModal', [null, null, false])
                    })
                    .catch(err => {
                        console.log("Ошибка: " + err);
                    }) 
        },
        editTeacher(ctx, [search, id, value]){
            axios
            .post('data/teachers/edit', {
                itemId: id,
                value: value,
            })
            .then(res => {
                ctx.dispatch('getTeachers', search);
                ctx.commit('updateModalEdit', [null, null, false])
            })
            .catch(err => {
                console.log("Ошибка: " + err);
            }) 
        }
    },
    mutations: {
        updateTeachers(state, data) {
            state.teachers = data;
        },
    },
    state: {
        teachers: [],       
    },
    getters: {
        teachers(state) {
            return state.teachers;
        },
    },

}