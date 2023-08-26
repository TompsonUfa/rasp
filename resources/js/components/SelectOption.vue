<template>
    <div class="option" v-if="option.title.length > 1">
        <input class="option__input" type="radio" name="option" :value="option.id" :checked="option.id === activeOption.id"
            @change="this.setActive(option)" @click="$emit('toggle')" />
        <div class="option__text">
            <i class="bx bx-group"></i> <span>{{ option.title }}</span>
        </div>
        <div class="option__bg"></div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import { mapGetters } from "vuex";
export default {
    props: {
        option: {
            type: Object,
            required: true,
        },
    },
    computed: {
        ...mapGetters(["activeOption"]),
    },
    methods: {
        ...mapActions(["setActive"]),
    },
    emits: ["toggle"],
};
</script>

<style lang="scss" scoped>
.option {
    position: relative;
    overflow: hidden;
    max-height: 44px;
    transition: 0.3s ease all;
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

    &:hover {
        color: #fff;
        background-color: var(--first-color-alt);

        i {
            animation: moveUp 0.3s ease;
            animation-iteration-count: 1;
        }
    }

    @keyframes moveUp {
        0% {
            padding-top: 40px;
        }

        100% {
            padding-top: 0px;
        }
    }

    &__input {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 3;
        color: var(--text-color);

        &:checked~.option__bg {
            background-color: var(--first-color-alt);
        }

        &:checked~.option__text {
            color: #fff;
        }

        &:hover~.option__text {
            color: #fff;
        }
    }

    &__text {
        position: relative;
        display: flex;
        gap: 30px;
        align-items: center;
        z-index: 2;
        color: var(--text-color);
    }

    &__bg {
        pointer-events: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
}

.dark {
    .option {
        color: var(--text-white);
    }
}
</style>
