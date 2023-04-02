<template>
    <h2 class="result__title">{{ this.day }}</h2>
    <table class="result__table">
        <thead>
            <tr>
                <th>Время</th>
                <th>Предмет / Преподаватель</th>
                <th>Тип занятия</th>
                <th>Аудитория</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="day in this.sortSchedule" :key="day.id">
                <td>{{ day.time }}</td>
                <td>
                    {{ day.lesson }}
                    <span>{{ day.teacher.title }}</span>
                </td>
                <td>
                    {{ day.category.title }}
                </td>
                <td>{{ day.room }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import moment from "moment";
import "moment/dist/locale/ru";
export default {
    props: {
        schedule: {
            type: Array,
            required: true,
        },
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
    },
};
</script>

<style lang="scss" scoped></style>
