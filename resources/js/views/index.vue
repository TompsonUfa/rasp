<template>
    <app-nav></app-nav>
    <app-content :filters="filters" @select="select"></app-content>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppContent from "@/components/AppContent.vue";
export default {
    components: {
        AppNav,
        AppContent,
    },
    data() {
        return {
            filters: [
                {
                    id: 1,
                    name: "Учебные группы",
                    active: true,
                    options: [
                        { id: 1, name: "Первая группа" },
                        { id: 2, name: "Вторая группа" },
                        { id: 3, name: "Третья группа" },
                        { id: 4, name: "Четвертая группа" },
                    ],
                },
                {
                    id: 2,
                    name: "Преподаватели",
                    active: false,
                    options: [
                        { id: 1, name: "Первый преподаватель" },
                        { id: 2, name: "Второй преподаватель" },
                        { id: 3, name: "Третий преподаватель" },
                        { id: 4, name: "Четвертый преподаватель" },
                    ],
                },
            ],
        };
    },
    methods: {
        select(event) {
            this.filters.forEach((filter, index) => {
                if (event != filter) {
                    filter.active = false;
                } else {
                    filter.active = true;
                }
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
