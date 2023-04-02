<template>
    <div class="date">
        <date-radio
            v-for="item in date"
            :key="item.id"
            :date="item"
        ></date-radio>
    </div>
</template>

<script>
import DateRadio from "@/components/DateRadio.vue";
import { mapActions } from "vuex";
export default {
    components: { DateRadio },
    data() {
        return {
            date: [
                {
                    id: 1,
                    name: "На сегодня",
                    value: "today",
                },
                {
                    id: 2,
                    name: "На завтра",
                    value: "tomorrow",
                },
                {
                    id: 3,
                    name: "На неделю",
                    value: "week",
                },
                {
                    id: 4,
                    name: "На следующую неделю",
                    value: "nextWeek",
                },
            ],
        };
    },
    mounted() {
        this.setActiveDate(this.date[0]);
    },
    methods: {
        ...mapActions(["setActiveDate"]),
    },
};
</script>

<style lang="scss" scoped>
.dark {
    .date {
        background: var(--body-color);
        color: #fff;
    }
}
</style>
