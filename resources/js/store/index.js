import { createStore } from "vuex"
import filter from "@/store/modules/filter.js"
import option from "@/store/modules/option.js"
const store = createStore({
    modules: {
        filter,
        option
    }
})

export default store;
