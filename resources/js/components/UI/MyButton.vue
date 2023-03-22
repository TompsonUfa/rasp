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
    padding: 10px 15px;
    color: #fff;
    background: var(--button-color);
    border: none;
    transition: 0.3s;
    border-radius: 10px;
    &:hover {
        background: var(--button-color-alt);
        color: #fff;
    }
    &_active {
        background: var(--button-color-alt);
        color: #fff;
    }
}
</style>
