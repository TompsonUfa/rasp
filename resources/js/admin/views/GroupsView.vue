<template>
    <content-panel :data="groups" :title="title"></content-panel>
</template>

<script>
import ContentPanel from "@/components/ContentPanel.vue";

import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            title: "Группы",
        }
    },
    computed: {
        ...mapGetters(["groups"]),
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["getGroups"]),
    },
    watch: {
        search(newSearch, oldSearch) {
            this.getGroups(newSearch);
        },
    },
    mounted() {
        this.getGroups(this.search);
    },
    components: {
        ContentPanel,
    },
};
</script>

<style lang="scss" scoped></style>
