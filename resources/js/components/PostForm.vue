<template>
    <form method="post" class="form">
        <select-box :filters="filters" class="form__select"></select-box>
    </form>
</template>

<script>
import SelectBox from "@/components/SelectBox.vue";
export default {
    components: { SelectBox },
    props: {
        filters: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
.form__select {
    margin-top: 30px;
}
</style>
