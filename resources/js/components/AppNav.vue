<template>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="https://www.bifk.ru/" class="nav__logo"> BIFK </a>
            <div @click="$emit('change-theme')" class="change-theme">
                <i v-if="dark === true" class="bx bx-sun"></i>
                <i v-else class="bx bx-moon"></i>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    props: {
        dark: {
            type: Boolean,
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
        transition: all 0.3s ease;
        &:hover {
            color: var(--title-color-alt);
        }
    }
    .change-theme {
        cursor: pointer;
        color: var(--title-color);
        i {
            transition: all 0.3s ease;
            font-size: 20px;
        }
        &:hover {
            i {
                color: var(--title-color-alt);
            }
        }
    }
}
</style>
