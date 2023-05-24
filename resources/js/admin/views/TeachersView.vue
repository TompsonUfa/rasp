<template>
    <content-panel :data="teachers" :title="title"></content-panel>
</template>

<script>
import ContentPanel from "@/components/ContentPanel.vue";

import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            title: "Преподаватели",
        }
    },
    computed: {
        ...mapGetters(["teachers"]),
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["getTeachers"]),
    },
    watch: {
        search(newSearch, oldSearch) {
            this.getTeachers(newSearch);
        },
    },
    mounted() {
        this.getTeachers(this.search);
    },
    components: {
        ContentPanel,
    },
};
</script>

<style lang="scss" scoped></style>
