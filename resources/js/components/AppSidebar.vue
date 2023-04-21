<template>
    <nav class="sidebar">
        <div class="sidebar__content">
            <div class="sidebar__logo">
                <a href="https://bifk.ru/">BIFK</a>
            </div>
            <ul class="sidebar__list">
                <li class="sidebar__item">
                    <a class="sidebar__link" href="/admin">Импорт расписания</a>
                </li>
                <li class="sidebar__item">
                    <a class="sidebar__link" href="/admin/groups"
                        >Учебные группы</a
                    >
                </li>
                <li class="sidebar__item">
                    <a class="sidebar__link" href="/admin/teachers"
                        >Преподаватели</a
                    >
                </li>
                <li class="sidebar__item">
                    <a class="sidebar__link" href="/admin/categories"
                        >Категории предметов</a
                    >
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
        border-bottom: 1px solid #fff;
        a {
            color: #fff;
        }
    }
    &__list {
        padding: 35px;
        list-style: none;
    }
    &__item {
        font-size: 18px;
        &_active {
            background-color: var(--button-color-alt);
        }
    }
    &__link {
        display: block;
        padding: 15px 10px;
        font-size: 18px;
        letter-spacing: 0.5px;
        color: #fff;
    }
}
</style>
