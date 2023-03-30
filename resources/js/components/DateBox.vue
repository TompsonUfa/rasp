<template>
    <div class="date">
        <date-radio
            v-for="item in date"
            :key="item.id"
            :date="item"
        ></date-radio>
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
