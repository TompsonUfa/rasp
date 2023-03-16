<template>
    <div class="option">
        <input class="option__input" type="radio" name="option" />
        <div class="option__text">
            <i class="bx bx-group"></i> <span><slot></slot></span>
        </div>
        <div class="option__bg"></div>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.option {
    position: relative;
    overflow: hidden;
    max-height: 44px;
    transition: 0.3s ease all;
    &:hover {
        color: #fff;
        background-color: var(--button-color-alt);
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
        &:checked {
            color: var(--second-color);
        }
        &:checked ~ .option__bg,
        &:checked ~ .option__text {
            color: var(--second-color);
            background-color: var(--button-color-alt);
        }
    }
    &__text {
        position: relative;
        display: flex;
        gap: 30px;
        align-items: center;
        z-index: 2;
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
</style>
