import { createStore } from "vuex"
import filter from "@/store/modules/filter.js"
import option from "@/store/modules/option.js"
import date from "@/store/modules/date.js"
import schedules from "@/store/modules/schedules.js"
import groups from "@/store/modules/groups.js"
import teachers from "@/store/modules/teachers.js"
import categories from "@/store/modules/categories.js"
import search from "@/store/modules/search.js"
import modalRemove from "@/store/modules/modalRemove.js"
import modalEdit from "@/store/modules/modalEdit.js"

const store = createStore({
    modules: {
        filter,
        option,
        date,
        schedules,
        groups,
        teachers,
        categories,
        search,
        modalRemove,
        modalEdit
    }
})

export default store;
