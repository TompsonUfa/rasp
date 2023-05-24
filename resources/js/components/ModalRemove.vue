<template>
    <div class="modal">
        <div class="modal__content">
            <h3 class="modal__title">Удаление записи</h3>
            <p class="modal__text">Вы точно хотите удалить запись: {{ this.modalRemoveData.itemName }}</p>
            <div class="modal__btns">
                <button class="modal__btn modal__btn_remove" @click=this.remove>Удалить</button>
                <button class="modal__btn modal__btn_close" @click=this.closeModalRemove>Закрыть</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    computed: {
        ...mapGetters(["modalRemoveData"]),
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["closeModalRemove"]),
        ...mapActions(["deleteGroup"]),
        ...mapActions(["deleteTeacher"]),
        ...mapActions(["deleteCategory"]),
        remove() {
            const componentName = this.modalRemoveData.name;
            if (componentName == "Groups") {
                this.deleteGroup([this.search, this.modalRemoveData.itemId]);
            } else if (componentName == "Teachers") {
                this.deleteTeacher([this.search, this.modalRemoveData.itemId]);
            } else if (componentName == "Categories") {
                this.deleteCategory([this.search, this.modalRemoveData.itemId]);
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background-color: #0000007c;
    z-index: 2000;

    &__content {
        max-width: 900px;
        height: auto;
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
    }

    &__title {
        margin-bottom: 20px;
        font-size: 22px;
    }

    &__text {
        margin-bottom: 20px;
        font-size: 18px;
    }

    &__btns {
        display: flex;
        justify-content: right;
        gap: 15px;
    }

    &__btn {
        cursor: pointer;
        border-radius: 5px;
        color: #fff;
        border: none;
        padding: 10px 15px;
        font-size: 15px;
        opacity: 0.7;
        transition: 0.3s ease;
        font-weight: bold;

        &:hover {
            opacity: 1;
        }

        &_remove {
            background-color: red;
        }

        &_close {
            background-color: #000;
        }
    }
}
</style>