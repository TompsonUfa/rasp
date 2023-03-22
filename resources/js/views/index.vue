<template>
    <app-nav :themeMode="themeMode" @change-theme="changeTheme"></app-nav>
    <app-content :date="date" :filters="filters" @select="select"></app-content>
    <my-loader v-if="this.loading"></my-loader>
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
            loading: false,
            themeMode: "",
        };
    },
    watch: {
        loading: function () {
            document.body.style.overflow = this.loading ? "hidden" : "";
        },
    },
    mounted() {
        const initUserTheme = this.getTheme() || this.getMediaPreference();
        this.themeMode = initUserTheme;
        this.setTheme(initUserTheme);
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
        setTheme(theme) {
            localStorage.setItem("theme-mode", theme);
            this.themeMode = theme;
            if (theme === "dark") {
                document.body.classList.add("dark");
            } else {
                document.body.classList.remove("dark");
            }
        },
        changeTheme() {
            const themeMode = this.themeMode;
            if (themeMode === "dark") {
                this.setTheme("light");
            } else {
                this.setTheme("dark");
            }
        },
        getMediaPreference() {
            const hasDarkPreference = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;
            if (hasDarkPreference) {
                return "darm";
            } else {
                return "light";
            }
        },
        getTheme() {
            return localStorage.getItem("theme-mode");
        },
    },
};
</script>

<style lang="scss" scoped></style>
