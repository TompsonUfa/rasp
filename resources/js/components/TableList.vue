<template>
    <div class="wrapper-table">
        <table class="table">
            <thead class="table__head">
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Создан</th>
                    <th>Обновлен</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody class="table__body">
                <tr v-for="item in data" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.title }}</td>
                    <td>
                        {{
                            moment(item.created_at).format(
                                "DD-MM-YYYY HH:mm:ss"
                            )
                        }}
                    </td>
                    <td>
                        {{
                            moment(item.updated_at).format(
                                "DD-MM-YYYY HH:mm:ss"
                            )
                        }}
                    </td>
                    <td>
                        <div class="table__btns">
                            <div
                                class="btn btn_edit"
                                @click="modalOpenEdit(item)"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    width="24px"
                                    height="24px"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g
                                        id="SVGRepo_bgCarrier"
                                        stroke-width="0"
                                    ></g>
                                    <g
                                        id="SVGRepo_tracerCarrier"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g id="Edit / Edit_Pencil_01">
                                            <path
                                                id="Vector"
                                                d="M12 8.00012L4 16.0001V20.0001L8 20.0001L16 12.0001M12 8.00012L14.8686 5.13146L14.8704 5.12976C15.2652 4.73488 15.463 4.53709 15.691 4.46301C15.8919 4.39775 16.1082 4.39775 16.3091 4.46301C16.5369 4.53704 16.7345 4.7346 17.1288 5.12892L18.8686 6.86872C19.2646 7.26474 19.4627 7.46284 19.5369 7.69117C19.6022 7.89201 19.6021 8.10835 19.5369 8.3092C19.4628 8.53736 19.265 8.73516 18.8695 9.13061L18.8686 9.13146L16 12.0001M12 8.00012L16 12.0001"
                                                stroke="rgb(64,199,129)"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            ></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div
                                class="btn btn_delete"
                                @click="modalOpenRemove(item)"
                            >
                                <svg
                                    fill="red"
                                    version="1.1"
                                    id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="64px"
                                    height="64px"
                                    viewBox="0 0 482.428 482.429"
                                    xml:space="preserve"
                                    stroke="red"
                                >
                                    <g
                                        id="SVGRepo_bgCarrier"
                                        stroke-width="0"
                                    ></g>
                                    <g
                                        id="SVGRepo_tracerCarrier"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g>
                                                <path
                                                    d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098 c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117 h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828 C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879 C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096 c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266 c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979 V115.744z"
                                                ></path>
                                                <path
                                                    d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07 c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z"
                                                ></path>
                                                <path
                                                    d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07 c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z"
                                                ></path>
                                                <path
                                                    d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07 c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import moment from "moment";
import { mapActions } from "vuex";

export default {
    data() {
        return {
            moment: moment,
        };
    },
    props: { data: Array },
    methods: {
        ...mapActions(["openModalRemove"]),
        ...mapActions(["openModalEdit"]),
        modalOpenRemove(item) {
            const modalData = {
                name: this.$route.name,
                item: item,
            };
            this.openModalRemove(modalData);
        },
        modalOpenEdit(item) {
            const modalData = {
                name: this.$route.name,
                item: item,
            };
            this.openModalEdit(modalData);
        },
    },
};
</script>

<style lang="scss" scoped>
.wrapper-table {
    width: 100%;
    height: 100%;
    min-height: 500px;
    max-height: 500px;
    overflow: auto;
    background-color: #fff;
    border: 1px solid #f2f2f2;
    border-radius: 5px;

    &::-webkit-scrollbar {
        width: 0px;
    }
}

.table {
    width: 100%;
    border-collapse: collapse;

    &__head {
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: var(--first-color-alt);
        color: #fff;

        th:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2) {
            width: 30%;
        }

        th:nth-child(3) {
            width: 20%;
        }

        th:nth-child(4) {
            width: 20%;
        }

        th:nth-child(5) {
            width: 20%;
        }
    }

    &__body {
        tr {
            background-color: #fff;

            &:nth-child(even) {
                background-color: #f2f2f2;
            }
        }
    }

    &__btns {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    th,
    td {
        text-align: center;
        padding: 10px 15px;
    }

    tr {
        letter-spacing: 0.5px;
    }

    .btn {
        cursor: pointer;

        &_delete {
            transition: 0.3s ease-in-out;
            opacity: 0.7;

            &:hover {
                opacity: 1;
            }

            svg {
                width: 24px;
                height: auto;
            }
        }
    }
}
</style>
