<template>
    <div class="content__panel panel">
        <h1 class="panel__title">{{ title }}</h1>
        <search-form></search-form>
        <table-list :data=data></table-list>
    </div>
</template>

<script>
import TableList from "@/components/TableList.vue";
import SearchForm from "@/components/SearchForm.vue";

export default {
    props: { title: String, data: Array },
    components: {
        TableList,
        SearchForm
    },
};
</script>

<style lang="scss" scoped>
.panel {
    width: 100%;
    background-color: #fff;
    padding: 45px;

    &__title {
        margin-bottom: 25px;
    }
}
</style>
