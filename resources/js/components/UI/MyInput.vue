<template>
    <input class="input" type="text" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>

<script>
export default {
    name: "my-input",
    props: ['modelValue'],
    emits: ['update:modelValue']
};
</script>

<style lang="scss" scoped>
.input {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    outline: none;
    transition: 0.3s ease;
    letter-spacing: 0.7px;

    &:focus {
        border: 1px solid var(--first-color-alt);
    }
}
</style>
