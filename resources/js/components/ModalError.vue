<template>
    <div class="modal modal-error" @click="this.closeModal">
        <div class="modal__content">
            <div class="modal__btn">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Menu / Close_SM">
                            <path id="Vector" d="M16 16L12 12M12 12L8 8M12 12L16 8M12 12L8 16" stroke="#c0c5cb"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </g>
                </svg>
            </div>
            <div class="modal__img">
                <img src="404.jpg" alt="Результат не найден">
            </div>
            <h3 class="modal__title">Расписание не найдено</h3>
            <p class="modal__desc">
                Проверьте введенные данные и попробуйте снова.
            </p>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["closeModal"],
    methods: {
        closeModal(e) {
            const target = e.target;
            if (target.classList.contains('modal') || target.classList.contains('modal__btn')) {
                this.$emit('closeModal');
            }
        }
    },
}
</script>

<style lang="scss" scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: #00000083;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;

    &__content {
        position: relative;
        width: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #fff;
        color: #000;
        text-align: center;
        border-radius: 20px;
        padding: 30px 30px 70px;
        z-index: 1001;
        box-shadow: #ffffff18 0px 7px 29px 0px;
    }

    &__btn {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 30px;
        height: 30px;
        cursor: pointer;

        &:hover {
            svg {
                path {
                    stroke: var(--first-color-alt);
                }

            }

        }

        svg {
            pointer-events: none;

            path {
                transition: 0.3s ease;
            }
        }
    }

    h3,
    p,
    img {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
        pointer-events: none;
    }

    &__img {
        width: 150px;
        height: 150px;

        img {
            width: inherit;
            height: inherit;
        }
    }

    &__title {
        color: #000;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    &__desc {
        color: #5c5a5a;
    }
}
</style>