<template>
    <app-nav :themeMode="themeMode" @change-theme="changeTheme"></app-nav>
    <app-content :date="date"></app-content>
    <my-loader v-show="this.loading"></my-loader>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppContent from "@/components/AppContent.vue";
import { mapGetters } from "vuex";
import { mapActions } from "vuex";
export default {
    components: {
        AppNav,
        AppContent,
    },
    computed: {
        ...mapGetters(["filters", "activeOption"]),
    },
    data() {
        return {
            date: [
                {
                    id: 1,
                    name: "На сегодня",
                    value: "today",
                    active: true,
                },
                {
                    id: 2,
                    name: "На завтра",
                    value: "tomorrow",
                    active: false,
                },
                {
                    id: 3,
                    name: "На неделю",
                    value: "week",
                    active: false,
                },
                {
                    id: 4,
                    name: "На следующую неделю",
                    value: "nextWeek",
                    active: false,
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
        this.fetchGroups();
        this.fetchTeachers();
        const initUserTheme = this.getTheme() || this.getMediaPreference();
        this.themeMode = initUserTheme;
        this.setTheme(initUserTheme);
    },
    methods: {
        ...mapActions(["fetchTeachers", "fetchGroups", "setActive"]),
        // selectDate(event) {
        //     this.date.forEach((item, index) => {
        //         if (event != item) {
        //             item.active = false;
        //         } else {
        //             item.active = true;
        //         }
        //     });
        // },
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
        // submitForm() {
        //     this.loading = true;

        //     let activeFilter = "",
        //         activeDate = "";

        //     this.filters.forEach((filter, index) => {
        //         if (filter.active) {
        //             activeFilter = filter.id;
        //         }
        //     });

        //     this.date.forEach((item, index) => {
        //         if (item.active) {
        //             activeDate = item.id;
        //         }
        //     });

        //     axios
        //         .post("/", {
        //             filter: activeFilter,
        //             activeDate: activeDate,
        //             activeItem: this.activeItem,
        //         })
        //         .then((res) => {
        //             this.loading = false;
        //             console.log("Ответ: " + res);
        //         })
        //         .catch((error) => {
        //             this.loading = false;
        //             console.log("Ошибки: " + error);
        //         });
        // },
    },
};
</script>

<style lang="scss" scoped></style>
