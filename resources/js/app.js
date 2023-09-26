import "./bootstrap";
import "../css/app.scss";
import * as bootstrap from 'bootstrap';

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
//import { InertiaProgress } from "@inertiajs/progress";
import timeago from 'vue-timeago3'
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
import { createPinia } from 'pinia'
import NavBar from './Components/Global/NavBar.vue'



const pinia = createPinia()


createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) });
        VueApp.config.globalProperties.$route = route;
        return VueApp.use(plugin)
        .use(pinia)
        .use(ZiggyVue, Ziggy)
        .use(timeago)
        .component('NavBar', NavBar)
        .mount(el);
    }
});




//InertiaProgress.init({ color: "#000000", showSpinner: true });


livewire_hot_reload();




