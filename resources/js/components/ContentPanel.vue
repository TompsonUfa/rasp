<template>
    <div class="content__panel panel">
        <h1 class="panel__title">Группы</h1>
        <table-list></table-list>
    </div>
</template>

<script>
import TableList from "@/components/TableList.vue";
export default {
    components: {
        TableList,
    },
};
</script>

<style lang="scss" scoped>
.panel {
    width: 100%;
    max-width: 750px;
    &__title {
        margin-bottom: 25px;
    }
}
</style>
