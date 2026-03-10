import Chart from 'chart.js/auto'
import 'chartjs-adapter-moment'

import Alpine from 'alpinejs'

import Anchor from '@alpinejs/anchor'
import Collapse from '@alpinejs/collapse'
import Focus from '@alpinejs/focus'
import Ui from '@alpinejs/ui'

Chart.defaults.color = '#fff'
window.Chart = Chart

const colorScheme = window.matchMedia('(prefers-color-scheme: dark)')

const cachetTheme = {
    preference() {
        return localStorage.getItem('theme') ?? 'system'
    },
    resolved(theme = this.preference()) {
        if (theme === 'system') {
            return colorScheme.matches ? 'dark' : 'light'
        }

        return theme
    },
    apply(theme = this.preference()) {
        const resolvedTheme = this.resolved(theme)

        document.documentElement.classList.toggle('dark', resolvedTheme === 'dark')
        document.documentElement.classList.toggle('light', theme === 'light')
        window.theme = theme

        window.dispatchEvent(
            new CustomEvent('cachet-theme-changed', {
                detail: {
                    preference: theme,
                    theme: resolvedTheme,
                },
            }),
        )
    },
    set(theme) {
        localStorage.setItem('theme', theme)
        this.apply(theme)
    },
}

window.CachetTheme = cachetTheme

Alpine.plugin(Anchor)
Alpine.plugin(Collapse)
Alpine.plugin(Focus)
Alpine.plugin(Ui)

window.Alpine = Alpine
Alpine.start()

cachetTheme.apply()

colorScheme.addEventListener('change', () => {
    if (cachetTheme.preference() === 'system') {
        cachetTheme.apply('system')
    }
})

window.addEventListener('storage', (event) => {
    if (event.key === 'theme') {
        cachetTheme.apply(event.newValue ?? 'system')
    }
})
