<template>
    <main class="main">
        <section class="section schedule">
            <div class="container">
                <div class="schedule__content">
                    <h1 class="schedule__title">Расписание занятий</h1>
                    <app-filters></app-filters>
                    <post-form @submitForm="$emit('submitForm')"></post-form>
                </div>
                <app-result
                    v-if="this.schedulesShow"
                    class="schedule__result"
                ></app-result>
            </div>
        </section>
    </main>
</template>

<script>
import AppFilters from "@/components/AppFilters.vue";
import PostForm from "@/components/PostForm.vue";
import AppResult from "@/components/AppResult.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        AppFilters,
        PostForm,
        AppResult,
    },
    computed: {
        ...mapGetters(["schedulesShow"]),
    },
    inheritAttrs: false,
};
</script>
<style lang="scss" scoped>
.schedule {
    &__title {
        font-size: 35px;
        font-weight: 500;
        line-height: 40px;
        letter-spacing: 0.2rem;
        margin-bottom: 30px;
        text-align: center;
    }
    &__content {
        background: var(--second-color);
        border-radius: 15px;
        padding: 45px;
    }
    &__filters {
        display: flex;
        justify-content: center;
        gap: 30px;
    }
    &__result {
        margin-top: 30px;
        background: var(--second-color);
        border-radius: 15px;
        padding: 45px;
    }
}
</style>
