import { createApp } from "vue";
import store from "@/store";
import UUID from "vue3-uuid";
import "../sass/app.scss";

const app = createApp({});

import Index from "@/views/index.vue";
import Admin from "@/views/admin.vue";

import components from "@/components/UI";

app.component("index-vue", Index);
app.component("admin-vue", Admin);

components.forEach((component) => {
    app.component(component.name, component);
});

app.use(store, UUID);

app.mount("#app");
