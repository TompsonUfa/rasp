<template>
    <div class="date">
        <date-radio :date="date"></date-radio>
    </div>
</template>

<script>
import DateRadio from "@/components/DateRadio.vue";
export default {
    components: { DateRadio },
    props: {
        date: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
.dark {
    .date {
        background: var(--body-color);
        color: #fff;
    }
}
</style>
