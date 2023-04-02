<template>
    <app-nav :themeMode="themeMode" @change-theme="changeTheme"></app-nav>
    <form
        @submit.prevent="submitFile"
        style="margin-top: 200px"
        method="post"
        enctype="multipart/form-data"
    >
        <input
            @change="this.handleFileUpload"
            type="file"
            name="file"
            multiple="multiple"
        />
        <button type="submit">Загрузить</button>
    </form>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import axios from "axios";
export default {
    components: {
        AppNav,
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    data() {
        return {
            showBtnUp: false,
            themeMode: "",
            files: [],
        };
    },
    mounted() {
        const initUserTheme = this.getTheme() || this.getMediaPreference();
        this.themeMode = initUserTheme;
        this.setTheme(initUserTheme);
    },
    methods: {
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
        handleFileUpload(event) {
            this.files = event.target.files[0];
        },
        submitFile() {
            let formData = new FormData();
            formData.append("file", this.files);
            axios
                .post("create", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
