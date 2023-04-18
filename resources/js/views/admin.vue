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
            name="files"
            multiple="multiple"
        />
        <button type="submit">Загрузить</button>
    </form>
    <progress
        v-for="file in files"
        :key="file.id"
        id="progressBar"
        :value="progress"
        max="100"
    ></progress>
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
            current_row: 0,
            total_rows: 0,
            progress: 0,
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
            this.files = event.target.files;
        },
        async submitFile() {
            let files = this.files;
            let formData = new FormData();
            let self = this;
            for (let i = 0; i < files.length; i++) {
                formData.append("file", files[i]);
                await axios
                    .post("/admin/create", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                        onUploadProgress: async () => {
                            await self.getData(files[i].name);
                        },
                    })
                    .then((res) => {
                        console.log(res);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        async getData(filename) {
            while (true) {
                const { data } = await axios.get("/import-status/" + filename);
                if (data.finished) {
                    this.current_row = this.total_rows;
                    this.progress = 100;
                    break;
                }
                this.total_rows = data.total_rows;
                this.current_row = data.current_row;

                this.progress = Math.ceil(
                    (data.current_row / data.total_rows) * 100
                );
                await new Promise((resolve) => setTimeout(resolve, 2000)); // добавляем задержку, чтобы не перегружать сервер
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
