import { createStore } from "vuex"
import filter from "@/store/modules/filter.js"
import option from "@/store/modules/option.js"
import date from "@/store/modules/date.js"
import schedules from "@/store/modules/schedules.js"

const store = createStore({
    modules: {
        filter,
        option,
        date,
        schedules
    }
})

export default store;
