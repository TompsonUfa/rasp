<template>
    <form @submit.prevent="$emit('submitForm')" method="post" class="form">
        <select-box class="form__select"></select-box>
        <date-box class="form__date"></date-box>
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
};
</script>

<style lang="scss" scoped>
.form {
    &__select {
        margin: 30px 0;
    }
    &__controls {
        text-align: center;
        margin-top: 30px;
    }
}
</style>
