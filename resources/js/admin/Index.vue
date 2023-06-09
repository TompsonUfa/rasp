<template>
    <div class="wrapper">
        <app-sidebar></app-sidebar>
        <div class="main">
            <div class="content">
                <div class="container">
                    <router-view />
                    <modal-edit v-if="this.modalEditStatus"></modal-edit>
                    <modal-remove v-if="this.modalRemoveStatus"></modal-remove>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppSidebar from "@/components/AppSidebar.vue";
import ModalRemove from "@/components/ModalRemove.vue";
import ModalEdit from "@/components/ModalEdit.vue";
import { mapGetters } from "vuex";

export default {
    components: {
        AppNav,
        AppSidebar,
        ModalRemove,
        ModalEdit
    },
    computed: {
        ...mapGetters(["modalRemoveStatus"]),
        ...mapGetters(["modalEditStatus"]),
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
    },
};
</script>

<style lang="scss" scoped>
.wrapper {
    display: flex;
}

.content {
    width: 100%;
    height: 100%;
}

.container {
    width: 100%;
    max-width: 1200px;
    height: 100%;
    padding: 0px 25px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
