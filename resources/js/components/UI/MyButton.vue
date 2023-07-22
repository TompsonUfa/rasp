<template>
    <button class="button"><slot></slot></button>
</template>

<script>
export default {
    name: "my-button",
};
</script>

<style lang="scss" scoped>
.button {
    cursor: pointer;
    font-size: 17px;
    font-weight: 500;
    padding: 15px;
    color: var(--first-color-alt);
    background: var(--first-color);
    border: none;
    transition: 0.3s;
    border-radius: 15px;
    border: 1px solid var(--first-color-alt);
    &:hover {
        border: 1px solid var(--first-color-alt);
        background: var(--first-color-alt);
        color: #fff;
    }
    &_active {
        border: 1px solid var(--first-color-alt);
        background: var(--first-color-alt);
        color: #fff;
    }
}
.dark {
    .button {
        border: 1px solid transparent;
    }
}
</style>
