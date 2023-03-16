<template>
    <form method="post" class="form">
        <div class="form__select select-box">
            <input type="checkbox" class="select-box__view" />
            <div class="select-box__title">
                <span>Select Option</span> <i class="bx bx-chevron-down"></i>
            </div>
            <div class="select-box__options">
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
                <div class="select-box__option">
                    <i class="bx bx-group"></i> <span>Первый пункт</span>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.form__select {
    margin-top: 30px;
}
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
        border: 1px solid #e2eded;
        border-color: #eaf1f1 #e4eded #dbe7e7 #e4eded;
        i {
            font-size: 30px;
            color: #d1dede;
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
        overflow: scroll;
        border: 1px solid #e2eded;
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
