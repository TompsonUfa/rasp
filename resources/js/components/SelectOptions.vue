<template>
    <div>
        <select-option
            v-for="option in options"
            :key="option.key"
            :option="option"
            class="select-box__option"
        ></select-option>
    </div>
</template>
<script>
import SelectOption from "@/components/SelectOption.vue";
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters(["filters"]),
        options() {
            const activeFilter = this.filters.filter((filter) => filter.active);
            return activeFilter[0].options;
        },
    },
    components: { SelectOption },
};
</script>
<style lang="scss" scoped></style>
