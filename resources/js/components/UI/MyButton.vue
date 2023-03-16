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
    font-weight: 700;
    padding: 10px 15px;
    background: none;
    color: var(--button-color);
    border: 3px solid var(--button-color);
    transition: 0.3s;
    &:hover {
        border: 3px solid var(--button-color-alt);
        background: var(--button-color-alt);
        color: #fff;
    }
    &_active {
        border: 3px solid var(--button-color-alt);
        background: var(--button-color-alt);
        color: #fff;
    }
}
</style>
