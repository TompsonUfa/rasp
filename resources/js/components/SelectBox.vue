<template>
    <div class="select-box">
        <input type="checkbox" class="select-box__view" v-model="checked" />
        <div class="select-box__title">
            <span></span>
            <i class="bx bx-chevron-down"></i>
        </div>
        <select-options class="select-box__options"></select-options>
    </div>
</template>

<script>
import SelectOptions from "@/components/SelectOptions.vue";

export default {
    components: { SelectOptions },

    data() {
        return {
            checked: false,
        };
    },
};
</script>

<style lang="scss" scoped>
.select-box {
    position: relative;
    width: 100%;

    &__view {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    &__view:checked + &__title i {
        color: var(--button-color-alt);
        rotate: 180deg;
    }

    &__title {
        display: flex;
        height: 56px;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        border-radius: 10px;
        i {
            pointer-events: none;
            font-size: 30px;
            color: var(--border-color);
            transition: 0.3s;
        }
    }

    &__options {
        display: none;
        position: absolute;
        top: 60px;
        left: 0;
        background-color: var(--second-color);
        width: 100%;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        z-index: 1;
        border-radius: 10px;
    }

    &__view:checked ~ &__options {
        display: block;
    }
}
.dark {
    .select-box {
        &__title {
            background: var(--body-color);
            color: var(--text-color);
        }
        &__options {
            background: var(--body-color);
        }
    }
}
</style>
