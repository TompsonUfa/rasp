<template>
    <app-nav :dark="dark" @change-theme="changeTheme"></app-nav>
    <app-content
        @move-up="moveUp"
        :dark="dark"
        @submit-form="submitForm"
    ></app-content>
    <sections-menu
        @scrollToSection="scrollToSection"
        :activeSection="activeSection"
        :offsets="offsets"
    ></sections-menu>
    <my-loader v-show="this.loading"></my-loader>
    <modal-error @closeModal="showModal = false" v-if="showModal"></modal-error>
    <button-up @click="scrollToTop" v-if="this.showBtnUp"></button-up>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppContent from "@/components/AppContent.vue";
import SectionsMenu from "@/components/SectionsMenu.vue";
import ModalError from "@/components/ModalError.vue";
import { mapGetters, mapActions } from "vuex";

export default {
    components: {
        AppNav,
        AppContent,
        SectionsMenu,
        ModalError,
    },
    computed: {
        ...mapGetters([
            "filters",
            "activeOption",
            "date",
            "schedules",
            "schedulesVisible",
        ]),
        createdSchedules() {
            return this.schedulesVisible;
        },
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    data() {
        return {
            loading: false,
            showBtnUp: false,
            dark: "",
            inMove: false,
            activeSection: 0,
            offsets: [],
            touchStartY: 0,
            showModal: false,
        };
    },
    watch: {
        loading: function () {
            document.body.style.overflow = this.loading ? "hidden" : "";
        },
        createdSchedules: {
            handler() {
                this.offsets = [];
                this.calcSectionOffsets();
            },
            flush: "post",
        },
    },
    mounted() {
        this.calcSectionOffsets();
        this.fetchGroups();
        this.fetchTeachers();
        const initUserTheme = this.getTheme() || this.getMediaPreference();
        this.dark = initUserTheme;
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
        //theme
        setTheme(theme) {
            localStorage.setItem("theme-mode", theme);
            if (theme === "dark") {
                this.dark = true;
                document.body.classList.add("dark");
            } else {
                this.dark = false;
                document.body.classList.remove("dark");
            }
        },
        changeTheme() {
            if (this.dark === true) {
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
        //form
        submitForm() {
            this.loading = true;
            const activeFilter = this.filters.filter(
                (filter) => filter.active
            )[0].id;
            const activeOption = this.activeOption.id;
            const date = this.date;
            this.fetchSchedules([activeFilter, date, activeOption])
                .then((response) => {
                    this.loading = false;
                    if (Object.keys(response.data).length > 0) {
                        this.schedulesShow(true);
                    } else {
                        this.showModal = true;
                        this.schedulesShow(false);
                    }
                })
                .catch((error) => {
                    this.showModal = true;
                    this.loading = false;
                });
        },
        //scroll
        handleScroll() {
            const scrollDistance = window.scrollY;
            document.querySelectorAll(".section").forEach((el, i) => {
                if (scrollDistance >= el.offsetTop) {
                    if (this.activeSection != i) {
                        this.activeSection = i;
                    }
                }
            });
            if (window.scrollY > 200) {
                this.showBtnUp = true;
            } else {
                this.showBtnUp = false;
            }
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
        //scrollSection
        calcSectionOffsets() {
            let sections = document.querySelectorAll(".section");
            for (let i = 0; i < sections.length; i++) {
                let sectionOffset = sections[i].offsetTop;
                this.offsets.push(sectionOffset);
            }
        },
        scrollToSection(id, force = false) {
            let element = document.getElementsByTagName("section")[id];
            if (this.inMove && !force) return false;
            this.activeSection = id;
            this.inMove = true;
            element.scrollIntoView({
                top: 0,
                behavior: "smooth",
            });
            setTimeout(() => {
                this.inMove = false;
            }, 400);
        },
        moveDown() {
            this.inMove = true;
            this.activeSection--;
            if (this.activeSection < 0) this.activeSection = 0;
            this.scrollToSection(this.activeSection, true);
        },
        moveUp() {
            this.inMove = true;
            this.activeSection++;
            console.log(document.querySelectorAll("section"));
            if (this.activeSection > this.offsets.length - 1) {
                this.activeSection = this.offsets.length - 1;
            }
            this.scrollToSection(this.activeSection, true);
        },
    },
};
</script>

<style lang="scss" scoped></style>
