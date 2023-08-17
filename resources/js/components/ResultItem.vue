<template>
    <h2 class="result__title">{{ this.day }}</h2>
    <div class="result__wrap">
        <table class="result__table">
            <thead>
                <tr>
                    <th>Время</th>
                    <th>
                        Предмет /
                        {{
                            filter.name == "Учебные группы"
                                ? "Преподаватель"
                                : "Учебная группа"
                        }}
                    </th>
                    <th>Тип занятия</th>
                    <th>Аудитория</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="day in this.sortSchedule" :key="day.id">
                    <td>{{ day.time }}</td>
                    <td>
                        {{ day.lesson }}
                        <span>{{
                            filter.name == "Учебные группы"
                                ? day.teacher.title
                                : day.group.title
                        }}</span>
                    </td>
                    <td>
                        {{ day.category.title }}
                    </td>
                    <td>{{ day.room }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import moment from "moment";
import "moment/dist/locale/ru";
import { mapGetters } from "vuex";
export default {
    props: {
        schedule: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            filter: "",
        };
    },
    mounted() {
        let reft = this;
        for (let i = 0; i < this.filters.length; i++) {
            if (this.filters[i].active) {
                reft.filter = this.filters[i];
            }
        }
    },
    updated() {
        let reft = this;
        for (let i = 0; i < this.filters.length; i++) {
            if (this.filters[i].active) {
                reft.filter = this.filters[i];
            }
        }
    },
    computed: {
        day() {
            moment.locale("ru");
            return (
                moment(this.schedule[0].date).format("dddd") +
                " " +
                this.schedule[0].date
            );
        },
        sortSchedule() {
            return this.schedule.sort((a, b) =>
                a.position > b.position ? 1 : -1
            );
        },
        ...mapGetters(["filters"]),
    },
};
</script>

<style lang="scss"></style>
