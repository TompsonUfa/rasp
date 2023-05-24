<template>
    <content-panel :data="categories" :title="title"></content-panel>
</template>

<script>
import ContentPanel from "@/components/ContentPanel.vue";

import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            title: "Категории предметов",
        }
    },
    computed: {
        ...mapGetters(["categories"]),
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["getCategories"]),
    },
    watch: {
        search(newSearch, oldSearch) {
            this.getCategories(newSearch);
        },
    },
    mounted() {
        this.getCategories(this.search);
    },
    components: {
        ContentPanel,
    },
};
</script>

<style lang="scss" scoped></style>
