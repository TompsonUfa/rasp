<template>
    <div>
        <select-option
            v-for="option in options"
            :key="option.key"
            :option="option"
            class="select-box__option"
            @toggle="$emit('toggle')"
        ></select-option>
    </div>
</template>
<script>
import SelectOption from "@/components/SelectOption.vue";
import { mapGetters } from "vuex";
import { mapActions } from "vuex";
export default {
    computed: {
        ...mapGetters(["filters"]),
        options() {
            const activeFilter = this.filters.filter((filter) => filter.active);
            const firstOption = activeFilter[0].options[0];
            this.setActive(firstOption);
            return activeFilter[0].options;
        },
    },
    methods: {
        ...mapActions(["setActive"]),
    },
    components: { SelectOption },
};
</script>
<style lang="scss" scoped></style>
