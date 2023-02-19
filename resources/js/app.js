import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import DefaultLayout from "./Layouts/Default.vue";
import { Link } from '@inertiajs/inertia-vue'

Vue.use(plugin)
Vue.component('Link', Link)

const el = document.getElementById('app')

const urlParams = new URLSearchParams(window.location.search);

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => {
                const page = require(`./Pages/${name}`).default;
                page.layout = page.layout || DefaultLayout;
                return page;
            },
        },
    }),
    data: {
        search: urlParams.get('search') || '',
        status: urlParams.get('status') || '',
        withSilenced: urlParams.get('with-silenced') || '',
    }
}).$mount(el)