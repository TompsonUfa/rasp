<template>
    <VueDatePicker :dark="this.dark" v-model="date"></VueDatePicker>
</template>

<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            date: null,
            dark: false,
        };
    },
    mounted() {
        // this.setActiveDate(this.date[0]);
    },
    methods: {
        ...mapActions(["setActiveDate"]),
    },
};
</script>

<style lang="scss">
.dp__input {
    height: 56px;
}
</style>
