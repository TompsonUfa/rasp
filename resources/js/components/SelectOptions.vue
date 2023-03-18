<template>
    <div>
        <select-option
            @click="$emit('option', option)"
            v-for="option in options"
            :key="option.key"
            class="select-box__option"
            >{{ option.name }}</select-option
        >
    </div>
</template>
<script>
import SelectOption from "@/components/SelectOption.vue";
export default {
    components: { SelectOption },
    props: {
        options: {
            type: Array,
            required: true,
        },
    },
};
</script>
<style lang="scss" scoped></style>
