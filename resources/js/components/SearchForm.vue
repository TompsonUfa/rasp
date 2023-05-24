<template>
    <form class="form-search" @submit.prevent>
        <my-input class="form-search__input" placeholder="Поиск" v-model="searchQuery"
            @input=getFilteredData(searchQuery)></my-input>
    </form>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    data() {
        return {
            searchQuery: null,
        }
    },
    mounted() {
        this.getFilteredData(null);
    },
    computed: {
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["setSearch"]),
        getFilteredData(searchQuery) {
            this.setSearch(searchQuery);
        }
    },
};
</script>

<style lang="scss" scoped>
.form-search {
    margin-bottom: 25px;

    &__input {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .375rem;
        outline: none;
        transition: 0.3s ease;
        letter-spacing: 0.7px;

        &:focus {
            border: 1px solid var(--first-color-alt);
        }
    }
}
</style>