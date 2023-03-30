import axios from "axios";
export default {
    actions: {
        fetchGroups(ctx) {
            axios
                .get('api/groups')
                .then(res => {
                    ctx.commit('updateGroup', res.data.groups)
                })
                .catch(err => {
                    console.log("Ошибка: " + err);
                })
        },
        fetchTeachers(ctx) {
            axios
                .get('api/teachers')
                .then(res => {
                    ctx.commit('updateTeachers', res.data.teachers);
                })
                .catch(err => {
                    console.log("Ошибка: " + err)
                })
        },
        toggleActiveFilter(ctx, filter) {
            ctx.commit('updateFilters', filter)
        }
    },
    mutations: {
        updateGroup(state, group) {
            state.filters[0].options = group;
        },
        updateTeachers(state, teachers) {
            state.filters[1].options = teachers;
        },
        updateFilters(state, activefilter) {
            state.filters.forEach((filter, index) => {
                if (activefilter != filter) {
                    filter.active = false;
                } else {
                    filter.active = true;
                }
            });
        }
    },
    state: {
        filters: [
            {
                id: 1,
                name: "Учебные группы",
                active: true,
                options: [],
            },
            {
                id: 2,
                name: "Преподаватели",
                active: false,
                options: [],
            },
        ],
    },
    getters: {
        filters(state) {
            return state.filters;
        },
    },
}
