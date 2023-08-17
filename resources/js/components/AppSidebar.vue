<template>
    <nav class="sidebar">
        <div class="sidebar__content">
            <div class="sidebar__logo">
                <a href="https://bifk.ru/">BIFK</a>
            </div>
            <ul class="sidebar__list">
                <li class="sidebar__item" v-for="link in links" :key="link.id">
                    <router-link
                        class="sidebar__link"
                        :to="{ name: link.name }"
                        @click="$emit('close')"
                    >
                        {{ link.desc }}
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="sidebar__btn" @click="$emit('close')">
            <svg
                viewBox="-0.5 0 25 25"
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
                        d="M3 21.32L21 3.32001"
                        stroke="#000000"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    ></path>
                    <path
                        d="M3 3.32001L21 21.32"
                        stroke="#000000"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    ></path>
                </g>
            </svg>
        </div>
    </nav>
</template>

<script>
export default {
    emits: {
        close,
    },
    data() {
        return {
            links: [
                { id: 1, name: "Import", desc: "Импорт расписания" },
                { id: 2, name: "Groups", desc: "Учебные группы" },
                { id: 3, name: "Teachers", desc: "Преподавателия" },
                { id: 4, name: "Categories", desc: "Категории предметов" },
            ],
        };
    },
};
</script>

<style lang="scss" scoped>
.sidebar {
    min-width: 20%;
    max-width: 20%;
    background-color: #212529;
    border-right: 1px solid var(--body-color);
    transition: 0.4s;
    z-index: 500;

    &__content {
        height: 100vh;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        left: 0;
    }

    &__logo {
        height: 100px;
        font-size: 30px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;

        a {
            color: #fff;
        }
    }

    &__link {
        font-size: 18px;
        display: block;
        padding: 15px 10px 15px 25px;
        font-size: 15px;
        letter-spacing: 0.5px;
        color: #fff;
        transition: all 0.2s ease-in;

        &:hover {
            background: var(--first-color-alt);
        }
    }
    &__btn {
        display: none;
    }

    .router-link-active {
        background: var(--first-color-alt);
    }
}

@media screen and (max-width: 900px) {
    .sidebar {
        position: relative;
        display: none;

        &_open {
            display: block;
            position: fixed;
            width: 100vw;
            max-width: 100%;
        }
        &__btn {
            display: block;
            position: absolute;
            top: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            cursor: pointer;
            svg {
                path {
                    stroke: #fff;
                }
            }
        }
    }
}
</style>
