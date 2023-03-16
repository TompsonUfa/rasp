<template>
    <header class="header" id="header">
        <app-nav></app-nav>
    </header>
    <main class="main">
        <section class="section schedule">
            <div class="container">
                <h1 class="schedule__title">Расписание занятий</h1>
                <div class="schedule__content">
                    <app-filters
                        @select="select"
                        :filters="filters"
                    ></app-filters>
                    <post-form></post-form>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import AppNav from "@/components/AppNav.vue";
import AppFilters from "@/components/AppFilters.vue";
import PostForm from "@/components/PostForm.vue";
export default {
    components: {
        AppNav,
        AppFilters,
        PostForm,
    },
    data() {
        return {
            filters: [
                {
                    id: 1,
                    name: "Учебные группы",
                    value: "study",
                    active: true,
                },
                {
                    id: 2,
                    name: "Преподаватели",
                    value: "teacher",
                    active: false,
                },
            ],
        };
    },
    methods: {
        select(event) {
            this.filters.forEach((filter, index) => {
                if (event != filter) {
                    filter.active = false;
                } else {
                    filter.active = true;
                }
            });
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
