<template>
    <app-nav :dark="dark" @change-theme="changeTheme"></app-nav>
    <app-content :dark="dark" @submitForm="submitForm"></app-content>
    <sections-menu @scrollToSection="scrollToSection" :activeSection="activeSection" :offsets="offsets"></sections-menu>
    <my-loader v-show="this.loading"></my-loader>
    <button-up @click="scrollToTop" v-if="this.showBtnUp"></button-up>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppContent from "@/components/AppContent.vue";
import SectionsMenu from "@/components/SectionsMenu.vue";
import { mapGetters, mapActions } from "vuex";

export default {
    components: {
        AppNav,
        AppContent,
        SectionsMenu,
    },
    computed: {
        ...mapGetters(["filters", "activeOption", "date", "schedules", "schedulesVisible"]),
        schedulesCreated() {
            return this.schedulesVisible;
        }
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
        // window.addEventListener('wheel', this.handleMouseWheelDOM, {
        //     passive: false
        // }); // Mozilla Firefox
        // window.addEventListener('mousewheel', this.handleMouseWheel, {
        //     passive: false
        // }); // Other browsers
        // window.addEventListener('touchstart', this.touchStart, {
        //     passive: false
        // }); // mobile devices
        // window.addEventListener('touchmove', this.touchMove, {
        //     passive: false
        // }); // mobile devices
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
        window.removeEventListener('mousewheel', this.handleMouseWheel, {
            passive: false
        }); // Other browsers
        window.removeEventListener('wheel', this.handleMouseWheelDOM, {
            passive: false
        }); // Mozilla Firefox
        window.removeEventListener('touchstart', this.touchStart); // mobile devices
        window.removeEventListener('touchmove', this.touchMove); // mobile devices
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
        };
    },

    watch: {
        loading: function () {
            document.body.style.overflow = this.loading ? "hidden" : "";
        },
        schedulesCreated: function () {
            this.calcSectionOffsets();
        }
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
                        this.schedulesShow()
                    }
                })
                .catch((error) => {
                    this.loading = false;
                });
        },
        //scroll
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
        //scrollSection
        calcSectionOffsets() {
            let sections = document.querySelectorAll('.section');
            for (let i = 0; i < sections.length; i++) {
                let sectionOffset = sections[i].offsetTop;
                this.offsets.push(sectionOffset);
            }
        },
        scrollToSection(id, force = false) {
            let element = document.getElementsByTagName('section')[id]
            if (this.inMove && !force) return false;
            this.activeSection = id;
            this.inMove = true;
            element.scrollIntoView({
                top: 0,
                behavior: 'smooth'
            });
            setTimeout(() => {
                this.inMove = false;
            }, 400);
        },
        handleMouseWheelDOM: function (e) {
            if (e.deltaY > 0 && !this.inMove) {
                this.moveUp();
            } else if (e.deltaY < 0 && !this.inMove) {
                this.moveDown();
            }
            e.preventDefault();
            return false;
        },
        handleMouseWheel: function (e) {
            if (e.wheelDelta < 30 && !this.inMove) {
                this.moveUp();
            } else if (e.wheelDelta > 30 && !this.inMove) {
                this.moveDown();
            }
            e.preventDefault();
            return false;
        },
        moveDown() {
            this.inMove = true;
            this.activeSection--;
            if (this.activeSection < 0) this.activeSection = this.offsets.length - 1;
            this.scrollToSection(this.activeSection, true);
        },
        moveUp() {
            this.inMove = true;
            this.activeSection++;
            if (this.activeSection > this.offsets.length - 1) this.activeSection = 0;
            this.scrollToSection(this.activeSection, true);
        },
        touchStart(e) {
            e.preventDefault();
            this.touchStartY = e.touches[0].clientY;
        },
        touchMove(e) {
            if (this.inMove) return false;
            e.preventDefault();
            const currentY = e.touches[0].clientY;
            if (this.touchStartY < currentY) {
                this.moveDown();
            } else {
                this.moveUp();
            }
            this.touchStartY = 0;
            return false;
        }
        //endScroll
    },
};
</script>

<style lang="scss" scoped></style>
