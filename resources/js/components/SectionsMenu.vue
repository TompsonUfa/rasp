<template>
    <div class="section-menu">
        <span class="menu-point" :class="{ 'menu-point_active': activeSection == index }"
            @click="$emit('scrollToSection', index)" v-for="(offset, index) in offsets" :key="index">
        </span>
    </div>
</template>

<script>
export default {
    props: {
        offsets: {
            type: Array,
            required: true,
        },
        activeSection: {
            required: true,
        }
    },
    emits: ["scrollToSection"],
}
</script>

<style lang="scss" scoped>
.section-menu {
    position: fixed;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);

    .menu-point {
        width: 10px;
        height: 10px;
        background-color: var(--first-color-alt);
        display: block;
        margin: 1rem 0;
        opacity: .6;
        transition: 0.3s ease all;
        cursor: pointer;
        border-radius: 50%;

        &_active {
            opacity: 1;
            transform: scale(1.5);
        }
    }
}
</style>