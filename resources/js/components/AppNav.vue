<template>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="https://www.bifk.ru/" class="nav__logo"> BIFK </a>
            <div @click="$emit('change-theme')" class="change-theme">
                <i v-if="themeMode === 'dark'" class="bx bx-sun"></i>
                <i v-else class="bx bx-moon"></i>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    props: {
        themeMode: {
            type: String,
            required: true,
        },
    },
    emits: ["change-theme"],
};
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
