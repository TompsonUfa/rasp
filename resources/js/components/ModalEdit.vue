<template>
    <div class="modal">
        <div class="modal__content">
            <h3 class="modal__title">Редактирование записи</h3>
            <my-input class="modal__input" v-model="valueInput"></my-input>
            <div class="modal__btns">
                <button class="modal__btn modal__btn_edit" @click=this.edit>Редактировать</button>
                <button class="modal__btn modal__btn_close" @click=this.closeModalEdit>Закрыть</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            valueInput: null,
        }
    },
    mounted() {
        this.valueInput = this.modalEditData.itemName;
    },
    computed: {
        ...mapGetters(["modalEditData"]),
        ...mapGetters(["search"]),
    },
    methods: {
        ...mapActions(["closeModalEdit"]),
        ...mapActions(["editGroup"]),
        ...mapActions(["editTeacher"]),
        ...mapActions(["editCategory"]),
        edit() {
            const componentName = this.modalEditData.name;
            if (componentName == "Groups") {
                this.editGroup([this.search, this.modalEditData.itemId, this.valueInput]);
            } else if (componentName == "Teachers") {
                this.editTeacher([this.search, this.modalEditData.itemId, this.valueInput]);
            } else if (componentName == "Categories") {
                this.editCategory([this.search, this.modalEditData.itemId, this.valueInput]);
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

    &__input {
        margin-bottom: 25px;
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

        &_edit {
            background-color: green;
        }

        &_close {
            background-color: #000;
        }
    }
}
</style>