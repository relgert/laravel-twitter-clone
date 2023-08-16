import "./bootstrap";
import "../css/app.scss";
import * as bootstrap from 'bootstrap';

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { InertiaProgress } from "@inertiajs/progress";
import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
import { createPinia } from 'pinia'


const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        const VueApp = createApp({ render: () => h(app, props) });
        console.log(route);
        VueApp.config.globalProperties.$route = route;

        return VueApp.use(plugin)
        .use(pinia)
        .use(ZiggyVue, Ziggy)
        .mount(el);
    }
});




InertiaProgress.init({ color: "#000000", showSpinner: true });


livewire_hot_reload();




