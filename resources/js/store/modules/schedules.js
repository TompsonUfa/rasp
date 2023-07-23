import axios from "axios";
export default {
    actions: {
        fetchSchedules(ctx, [filer, date, option]) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/schedules", {
                        filter: filer,
                        date: date,
                        activeOption: option,
                    })
                    .then((res) => {
                        ctx.commit('updateSchedules', res.data)
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err)
                    });
            });
        },
        schedulesShow(ctx) {
            ctx.commit('toggleShow');
        }
    },
    mutations: {
        updateSchedules(state, data) {
            state.schedules = data;
        },
        toggleShow(state) {
            state.schedulesShow = true;
        }
    },
    state: {
        schedules: [],
        schedulesShow: false,
    },
    getters: {
        schedules(state) {
            return state.schedules;
        },
        schedulesVisible(state) {
            return state.schedulesShow;
        },
    },

}
