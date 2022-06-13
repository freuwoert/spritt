import './bootstrap'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

import MarketierUI from 'marketier-ui'
import 'marketier-ui/dist/style.css'



const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'



createInertiaApp({
    title(title)
    {
        return `${title} - ${appName}`
    },

    resolve(name)
    {
        return require(`./Pages/${name}.vue`)
    },

    setup({ el, app, props, plugin })
    {
        const application = createApp({ render: () => h(app, props) })

        application.use(plugin)
        application.use(MarketierUI)
        application.mixin({ methods: { route } })

        application.mount(el)

        return application
    },
})

InertiaProgress.init({ color: '#4B5563' })
