<template>
    <div class="wrapper">
        <app-sidebar
            :class="showSidebar ? 'sidebar_open' : null"
            @close="showSidebar = false"
        ></app-sidebar>
        <div class="main">
            <div class="content">
                <div class="container">
                    <div
                        class="btn-toggle"
                        @click="showSidebar = true"
                        v-if="!showSidebar"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M4 18L20 18"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                ></path>
                                <path
                                    d="M4 12L20 12"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                ></path>
                                <path
                                    d="M4 6L20 6"
                                    stroke="#000000"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                ></path>
                            </g>
                        </svg>
                    </div>
                    <router-view />
                    <modal-edit v-if="this.modalEditStatus"></modal-edit>
                    <modal-remove v-if="this.modalRemoveStatus"></modal-remove>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppSidebar from "@/components/AppSidebar.vue";
import ModalRemove from "@/components/ModalRemove.vue";
import ModalEdit from "@/components/ModalEdit.vue";
import { mapGetters } from "vuex";

export default {
    components: {
        AppNav,
        AppSidebar,
        ModalRemove,
        ModalEdit,
    },
    computed: {
        ...mapGetters(["modalRemoveStatus"]),
        ...mapGetters(["modalEditStatus"]),
    },

    data() {
        return {
            showBtnUp: false,
            showSidebar: false,
        };
    },
};
</script>

<style lang="scss" scoped>
.wrapper {
    display: flex;
}

.content {
    width: 100%;
    height: 100%;
}

.container {
    width: 100%;
    max-width: 1200px;
    height: 100%;
    padding: 0px 25px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.btn-toggle {
    display: none;
}
@media screen and (max-width: 900px) {
    .btn-toggle {
        display: block;
        width: 45px;
        height: 45px;
        position: fixed;
        top: 10px;
        left: 10px;
        cursor: pointer;
        svg {
            path {
                stroke: var(--first-color-alt);
            }
        }
    }
}
</style>
