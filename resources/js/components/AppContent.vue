<template>
    <main class="main">
        <section class="section schedule">
            <div class="container">
                <h1 class="schedule__title">Расписание занятий</h1>
                <div class="schedule__content">
                    <app-filters
                        v-bind="$attrs"
                        :filters="filters"
                    ></app-filters>
                    <post-form :date="date" :filters="filters"></post-form>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import AppFilters from "@/components/AppFilters.vue";
import PostForm from "@/components/PostForm.vue";
export default {
    components: {
        AppFilters,
        PostForm,
    },
    props: {
        filters: {
            type: Array,
            required: true,
        },
        date: {
            type: Array,
            required: true,
        },
    },
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
        padding: 30px 45px;
    }
    &__filters {
        display: flex;
        justify-content: center;
        gap: 30px;
    }
}
</style>
