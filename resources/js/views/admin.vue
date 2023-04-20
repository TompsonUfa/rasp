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
        :value="file.progress"
        max="100"
    ></progress>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import { uuid } from "vue3-uuid";
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
            let files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const fileObject = {
                    uuid: uuid.v4(),
                    file: files[i],
                    progress: 0,
                };
                this.files.push(fileObject);
            }
        },
        async submitFile() {
            let self = this;
            for (let i = 0; i < this.files.length; i++) {
                let formData = new FormData();
                formData.append("file", this.files[i].file);
                formData.append("uuid", this.files[i].uuid);
                await axios
                    .post("/admin/create", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                        onUploadProgress: async () => {
                            await self.getData(this.files[i]);
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
        async getData(file) {
            while (true) {
                const { data } = await axios.get("/import-status/" + file.uuid);
                if (data.finished) {
                    file.progress = 100;
                    break;
                }
                file.progress = Math.ceil(
                    (data.current_row / data.total_rows) * 100
                );
                await new Promise((resolve) => setTimeout(resolve, 2000)); // добавляем задержку, чтобы не перегружать сервер
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
