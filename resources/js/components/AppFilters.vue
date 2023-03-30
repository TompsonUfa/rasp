<template>
    <div class="schedule__filters">
        <my-button
            v-for="filter in filters"
            v-bind:class="filter.active ? 'button_active' : null"
            :key="filter.id"
            @click="this.toggleActiveFilter(filter)"
        >
            {{ filter.name }}
        </my-button>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { mapActions } from "vuex";
export default {
    computed: mapGetters(["filters"]),
    methods: {
        ...mapActions(["toggleActiveFilter"]),
    },
    inheritAttrs: false,
};
</script>

<style></style>
