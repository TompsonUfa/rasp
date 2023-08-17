<template>
    <form @submit.prevent="$emit('submit-form')" method="post" class="form">
        <select-box class="form__select"></select-box>
        <VueDatePicker
            :dark="this.dark"
            v-model="date"
            locale="ru"
            cancelText="Закрыть"
            selectText="Выбрать"
            range
            :partial-range="false"
            placeholder="Выбрать дату"
            :enable-time-picker="false"
            :format="format"
            :preset-ranges="presetRanges"
        >
            <template #yearly="{ label, range, presetDateRange }">
                <span @click="presetDateRange(range)">{{ label }}</span>
            </template>
        </VueDatePicker>
        <div class="form__controls">
            <my-button class="form__sumbit">Показать</my-button>
        </div>
    </form>
</template>

<script>
import SelectBox from "@/components/SelectBox.vue";
import { mapActions } from "vuex";
import { ref } from "vue";
import {
    startOfMonth,
    endOfMonth,
    startOfWeek,
    endOfWeek,
    addWeeks,
    format,
} from "date-fns";
export default {
    components: { SelectBox },
    props: {
        dark: Boolean,
    },
    data() {
        return {
            date: ref(),
            presetRanges: ref([
                { label: "Сегодня", range: [new Date(), new Date()] },
                {
                    label: "Текущая неделя",
                    range: [
                        startOfWeek(new Date(), { weekStartsOn: 1 }),
                        endOfWeek(new Date(), { weekStartsOn: 1 }),
                    ],
                },
                {
                    label: "Следующая неделя",
                    range: [
                        startOfWeek(addWeeks(new Date(), 1), {
                            weekStartsOn: 1,
                        }),
                        endOfWeek(addWeeks(new Date(), 1), { weekStartsOn: 1 }),
                    ],
                },
                {
                    label: "Текущий месяц",
                    range: [startOfMonth(new Date()), endOfMonth(new Date())],
                },
            ]),
        };
    },
    watch: {
        date(newDate, oldDate) {
            let date = [];
            newDate.forEach((element) => {
                date.push(this.formatDate(element));
            });

            this.setDate(date);
        },
    },
    mounted() {
        this.date = [new Date(), new Date()];
    },
    methods: {
        ...mapActions(["setDate"]),
        formatDate(date) {
            return format(date, "yyyy.MM.dd");
        },
        format(date) {
            let result = "";
            for (let i = 0; i < date.length; i++) {
                const day =
                    (date[i].getDate() < 10 ? "0" : "") +
                    date[i].getDate() +
                    "." +
                    (date[i].getMonth() < 10 ? "0" : "") +
                    (date[i].getMonth() + 1) +
                    "." +
                    date[i].getFullYear();

                if (i == 0) {
                    result = day;
                } else {
                    result += " - " + day;
                }
            }
            return result;
        },
    },
    emits: ["submit-form"],
};
</script>

<style lang="scss">
.form {
    &__select {
        margin: 30px 0;
    }
    &__controls {
        text-align: center;
        margin-top: 30px;
    }
    .dp__input {
        height: 56px;
    }
    .dp__input:hover {
        border-color: var(--first-color-alt);
    }
}
.action-row {
    display: flex;
    justify-content: end;
    width: 100%;
}
.dp__input_focus ~ svg {
    fill: var(--first-color-alt);
}
.dp__input_focus {
    border: 1px solid var(--dp-border-color);
}
svg {
    transition: all 0.2s ease;
}
@media screen and (max-width: 550px) {
    .dp__menu_content_wrapper {
        display: block;
    }
}
</style>
