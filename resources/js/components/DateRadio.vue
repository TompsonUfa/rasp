<template>
    <label class="radio" v-for="(el, index) in date" :key="el.key">
        <input
            type="radio"
            name="date"
            :value="el.value"
            :checked="index == 0"
        />
        <span>{{ el.name }}</span>
    </label>
</template>

<script>
export default {
    props: {
        date: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
$radioSize: 22px;
$radioBorder: var(--border-color);
$radioActive: var(--button-color-alt);
.radio {
    display: block;
    cursor: pointer;
    input {
        display: none;
        & + span {
            line-height: $radioSize;
            height: $radioSize;
            padding-left: $radioSize;
            display: block;
            position: relative;
            &:not(:empty) {
                padding-left: $radioSize + 8;
            }
            &:before,
            &:after {
                content: "";
                width: $radioSize;
                height: $radioSize;
                display: block;
                border-radius: 50%;
                left: 0;
                top: 0;
                position: absolute;
            }
            &:before {
                background: $radioBorder;
                transition: background 0.2s ease,
                    transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 2);
            }
            &:after {
                background: #fff;
                transform: scale(0.78);
                transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.4);
            }
        }
        &:checked + span {
            &:before {
                transform: scale(1.04);
                background: $radioActive;
            }
            &:after {
                transform: scale(0.4);
                transition: transform 0.3s ease;
            }
        }
    }
    &:hover {
        input {
            & + span {
                &:before {
                    transform: scale(0.92);
                }
                &:after {
                    transform: scale(0.74);
                }
            }
            &:checked + span {
                &:after {
                    transform: scale(0.4);
                }
            }
        }
    }
}
</style>
