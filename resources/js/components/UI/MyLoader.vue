<template>
    <div class="loader">
        <div class="loader__spinner"></div>
    </div>
</template>

<script>
export default {
    name: "my-loader",
};
</script>

<style lang="scss" scoped>
.loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 600;
    background: #0000008b;
    display: flex;
    justify-content: center;
    align-items: center;
    &__spinner {
        display: inline-block;
        width: 3rem;
        height: 3rem;
        vertical-align: -0.125em;
        border: 0.35em solid var(--title-color);
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: 0.75s linear infinite spinner;
        animation: 0.75s linear infinite spinner;
    }
}
@keyframes spinner {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
