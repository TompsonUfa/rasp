<template>
    <div class="result">
        <result-item
            v-for="schedule in this.schedules"
            :key="schedule.id"
            :schedule="schedule"
        ></result-item>
        <h2 v-if="this.schedules.length == 0" class="result__title">
            Занятий нет
        </h2>
    </div>
</template>

<script>
import resultItem from "@/components/ResultItem.vue";
import { mapGetters } from "vuex";
export default {
    components: { resultItem },
    computed: {
        ...mapGetters(["schedules"]),
    },
};
</script>

<style lang="scss">
.result {
    &__title {
        text-transform: capitalize;
        margin-top: 30px;
        text-align: center;
        letter-spacing: 1.7px;
        &:first-child {
            margin-top: 0;
        }
    }
    &__wrap {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }
    &__table {
        width: 100%;
        margin: 30px 0px;
        border-radius: 15px;
        border: 1px solid var(--border-color);
        border-spacing: 0;
        table-layout: fixed;
        &:last-child {
            margin-bottom: 0;
        }
        th {
            color: var(--title-color);
            padding: 20px 15px;
        }
        th,
        td {
            font-size: 18px;
            &:nth-child(1) {
                width: 124px;
            }
            &:nth-child(2) {
                width: 320px;
            }
            &:nth-child(3) {
                width: 200px;
            }
            &:nth-child(4) {
                width: 200px;
            }
        }
        tbody {
            tr:nth-child(odd) {
                background: rgba(0, 0, 0, 0.05);
            }
        }
        td {
            text-align: center;
            color: var(--text-color);
            padding: 20px 15px;
            span {
                font-size: 15px;
                padding-top: 5px;
                display: block;
                color: #000;
                opacity: 0.7;
            }
        }
    }
}
.dark {
    .result {
        &__table {
            background: var(--body-color);
            td {
                color: var(--text-color);
                span {
                    color: inherit;
                }
            }
        }
    }
}
</style>
