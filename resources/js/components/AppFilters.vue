<template>
    <div class="schedule__filters">
        <my-button
            v-bind:class="filter.active ? 'button_active' : null"
            v-for="filter in filters"
            :key="filter.id"
            @click="selectFilter(filter)"
        >
            {{ filter.name }}
        </my-button>
    </div>
</template>

<script>
export default {
    props: {
        filters: {
            type: Array,
            required: true,
        },
    },
    methods: {
        selectFilter(filter) {
            this.$emit("select", filter);
        },
    },
};
</script>

<style></style>
