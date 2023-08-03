<template>
    <nav class="sidebar">
        <div class="sidebar__content">
            <div class="sidebar__logo">
                <a href="https://bifk.ru/">BIFK</a>
            </div>
            <ul class="sidebar__list">
                <li class="sidebar__item">
                    <router-link class="sidebar__link" :to="{ name: 'Import' }">
                        Импорт расписания
                    </router-link>
                </li>
                <li class="sidebar__item">
                    <router-link class="sidebar__link" :to="{ name: 'Groups' }">
                        Учебные группы
                    </router-link>
                </li>
                <li class="sidebar__item">
                    <router-link class="sidebar__link" :to="{ name: 'Teachers' }">
                        Преподаватели
                    </router-link>
                </li>
                <li class="sidebar__item">
                    <router-link class="sidebar__link" :to="{ name: 'Categories' }">
                        Категории предметов
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {};
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

    .router-link-active {
        background: var(--first-color-alt);
    }
}

@media screen and (max-width: 900px) {
    .sidebar {
        display: none;

        .sidebar__open {
            display: block;
            position: fixed;
            width: 100vw;
            max-width: 100%;
        }
    }
}
</style>
