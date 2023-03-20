<template>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="https://www.bifk.ru/" class="nav__logo"> BIFK </a>
            <i class="bx bx-moon change-theme" id="theme-button"></i>
        </nav>
    </header>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.nav {
    height: var(--header-height);
    display: flex;
    justify-content: space-between;
    align-items: center;
    &__logo {
        display: inline-flex;
        align-items: center;
        column-gap: 0.25rem;
        font-weight: 600;
        transition: 0.3s;
        font-size: 20px;
        color: var(--title-color);
        &:hover {
            color: var(--first-color);
        }
    }
    .change-theme {
        cursor: pointer;
        color: var(--title-color);
        transition: 0.3s;
        &:hover {
            color: var(--first-color);
        }
    }
    i {
        font-size: 20px;
    }
}
</style>
