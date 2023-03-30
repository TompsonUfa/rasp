import { createApp } from 'vue';
import store from "@/store"

import '../sass/app.scss';



const app = createApp({});


import Index from "@/views/index.vue";
import components from "@/components/UI";

app.component('index-vue', Index);
components.forEach(component => {
    app.component(component.name, component)
});

app.use(store);
app.mount('#app');
