import { createApp } from "vue";
import { createRouter, createWebHistory } from 'vue-router'
import store from "@/store";
import UUID from "vue3-uuid";


import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import "../sass/app.scss";

const app = createApp({});

import Index from "@/App.vue";
import Admin from "@/admin/Index.vue";
import ImportView from "@/admin/views/ImportView.vue";
import GroupsView from "@/admin/views/GroupsView.vue";
import TeachersView from "@/admin/views/TeachersView.vue";
import CategoriesView from "@/admin/views/CategoriesView.vue";
import components from "@/components/UI";

const routes = [
    {name: "Import", path: '/admin', component: ImportView },
    {name: "Groups", path: '/admin/groups', component: GroupsView },
    {name: "Teachers", path: '/admin/teachers', component: TeachersView },
    {name: "Categories", path: '/admin/сategories', component: CategoriesView },
  ]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

app.component('VueDatePicker', VueDatePicker);
app.component("index-vue", Index);
app.component("admin-vue", Admin);

components.forEach((component) => {
    app.component(component.name, component);
});

app.use(router);
app.use(store, UUID);

app.mount("#app");
