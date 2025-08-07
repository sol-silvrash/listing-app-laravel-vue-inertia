import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from "ziggy-js"

import Main from "./Layouts/Main.vue"

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { init_theme } from './theme'
import { init_icons } from './icons'

createInertiaApp({
    title: (title) => `Listing App ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || Main
        return page
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Head', Head)
            .component('Link', Link)
            .component('FontAwesomeIcon', FontAwesomeIcon)
            .mount(el)
    },

    progress: {
        color: '#fff',
        includeCSS: true,
    },
})

//** Dark Mode */
init_theme()
init_icons()