<template>
    <div class="btn btn_up">
        <i class="bx bx-up-arrow-alt"></i>
    </div>
</template>

<script>
export default {
    name: "button-up",
};
</script>

<style lang="scss" scoped>
.btn {
    width: 45px;
    height: 45px;
    &_up {
        position: fixed;
        bottom: 40px;
        right: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        background: var(--first-color-alt);
        border-radius: 50%;
        transition: 0.3s;

        i {
            font-size: 30px;
            color: #fff;
        }
    }
}
</style>
