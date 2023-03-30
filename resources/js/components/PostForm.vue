<template>
    <form @submit="submitForm" method="post" class="form">
        <select-box class="form__select"></select-box>
        <date-box :date="date" class="form__date"></date-box>
        <div class="form__controls">
            <my-button class="form__sumbit">Показать</my-button>
        </div>
    </form>
</template>

<script>
import SelectBox from "@/components/SelectBox.vue";
import DateBox from "@/components/DateBox.vue";
export default {
    components: { SelectBox, DateBox },
    props: {
        date: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
.form {
    &__select {
        margin-top: 30px;
    }
    &__date {
        padding: 20px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    &__controls {
        text-align: center;
        margin-top: 30px;
    }
}
</style>
