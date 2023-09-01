<template>
    <div class="select-box">
        <input type="checkbox" class="select-box__view" v-model="checked" />
        <i class="bx bx-chevron-down"></i>
        <div class="select-box__title">
            <i class="bx bx-group select-box__icon"></i>
            <span>{{
                this.activeOption ? this.activeOption.title : null
            }}</span>
        </div>
        <select-options
            @toggle="toggle"
            class="select-box__options"
        ></select-options>
    </div>
</template>

<script>
import SelectOptions from "@/components/SelectOptions.vue";
import { mapGetters } from "vuex";
export default {
    components: { SelectOptions },
    computed: {
        ...mapGetters(["activeOption"]),
    },
    data() {
        return {
            checked: false,
        };
    },
    methods: {
        toggle() {
            this.checked = !this.checked;
        },
    },
};
</script>

<style lang="scss">
.select-box {
    position: relative;
    width: 100%;

    .bx-chevron-down {
        position: absolute;
        width: 40px;
        height: 28px;
        top: 50%;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        transform: translateY(-50%);
        font-size: 1.5rem;
        color: var(--icon-color);
        pointer-events: none;
    }

    &__view {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    &__view:hover ~ &__title {
        border-color: var(--first-color-alt);
    }

    &__title {
        display: flex;
        height: 56px;
        align-items: center;
        justify-content: space-between;
        padding: var(--dp-input-padding);
        padding-left: var(--dp-input-icon-padding);
        border: 1px solid var(--dp-border-color);
        color: var(--text-color);
        border-radius: 10px;
        transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
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

    &__view:checked ~ i {
        color: var(--first-color-alt);
        transform: translateY(-50%) rotate(180deg);
    }

    &__icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 13px;
        color: var(--icon-color);
        font-size: 17px;
    }

    i {
        transition: all 0.2s ease;
    }
}
.dark {
    .select-box {
        &__title {
            background-color: #212121;
            border: 1px solid #2d2d2d;
            color: var(--text-color);
        }

        &__options {
            background: var(--body-color);
        }
    }
}
@media screen and (max-width: 550px) {
    .select-box {
        &__options {
            max-height: 200px;
        }
    }
}
</style>
