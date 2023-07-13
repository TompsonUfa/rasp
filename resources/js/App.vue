<template>
    <app-nav :themeMode="themeMode" @change-theme="changeTheme"></app-nav>
    <app-content @submitForm="submitForm"></app-content>
    <my-loader v-show="this.loading"></my-loader>
    <button-up @click="scrollToTop" v-if="this.showBtnUp"></button-up>
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
        ...mapGetters(["filters", "activeOption", "activeDate", "schedules"]),
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    data() {
        return {
            loading: false,
            showBtnUp: false,
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
        ...mapActions([
            "fetchTeachers",
            "fetchGroups",
            "setActive",
            "fetchSchedules",
            "schedulesShow",
        ]),
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
                return "dark";
            } else {
                return "light";
            }
        },
        getTheme() {
            return localStorage.getItem("theme-mode");
        },
        submitForm() {
            this.loading = true;

            const activeFilter = this.filters.filter(
                (filter) => filter.active
            )[0].id;
            const activeOption = this.activeOption.id;
            const date = this.activeDate.id;

            this.fetchSchedules([activeFilter, date, activeOption])
                .then((response) => {
                    this.loading = false;
                    this.schedulesShow();
                })
                .catch((error) => {
                    this.loading = false;
                    console.log("Что-то, произошло не так. Попробуйте снова.");
                });
        },
        handleScroll() {
            if (window.scrollY > 200) {
                this.showBtnUp = true;
            } else {
                this.showBtnUp = false;
            }
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
    },
};
</script>

<style lang="scss" scoped></style>
