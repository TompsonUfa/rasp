<template>
    <div class="select-box">
        <input type="checkbox" class="select-box__view" />
        <div class="select-box__title">
            <span>Выбрать</span> <i class="bx bx-chevron-down"></i>
        </div>
        <select-options
            v-for="filter in findActiveFilter"
            :key="filter.id"
            :options="filter.options"
            class="select-box__options"
        ></select-options>
    </div>
</template>

<script>
import SelectOptions from "@/components/SelectOptions.vue";
export default {
    components: { SelectOptions },
    props: {
        filters: {
            type: Array,
            required: true,
        },
    },
    computed: {
        findActiveFilter() {
            return this.filters.filter((element) => {
                return element.active;
            });
        },
    },
};
</script>

<style lang="scss">
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
        border: 1px solid var(--text-color-light);
        border-color: #eaf1f1 #e4eded #dbe7e7 #e4eded;
        color: #000;
        font-weight: 500;
        i {
            pointer-events: none;
            font-size: 30px;
            color: var(--text-color);
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
        height: 300px;
        overflow-y: auto;
        border: 1px solid var(--text-color-light);
        border-color: #eaf1f1 #e4eded #dbe7e7 #e4eded;
    }

    &__view:checked ~ &__options {
        display: block;
    }

    &__option {
        display: flex;
        align-items: center;
        column-gap: 20px;
        line-height: 1;
        padding: 12px 14px;
        transition: 0.3s;
        cursor: pointer;
        i {
            font-size: 20px;
        }
    }
}
</style>
