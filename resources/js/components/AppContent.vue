<template>
    <main class="main">
        <section class="section section__filters filters" id="filters">
            <div class="container">
                <div class="filters__content">
                    <h1 class="filters__title">Расписание занятий</h1>
                    <app-filters></app-filters>
                    <post-form
                        :dark="dark"
                        @submitForm="$emit('submitForm')"
                    ></post-form>
                </div>
            </div>
        </section>
        <section
            class="section section__schedule schedule"
            id="schedule"
            v-if="this.schedulesVisible"
        >
            <div class="container">
                <app-result
                    @moveUp="$emit('moveUp', $event)"
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
    props: {
        dark: Boolean,
    },
    computed: {
        ...mapGetters(["schedulesVisible"]),
    },

    inheritAttrs: false,
    emits: ["moveUp"],
};
</script>
<style lang="scss" scoped>
.filters {
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

    &__btns {
        display: flex;
        justify-content: center;
        gap: 30px;
    }
}

@media screen and (max-width: 590px) {
    .filters {
        &__btns {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }
    }
}
</style>
