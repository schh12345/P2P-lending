

import { defineNuxtConfig } from 'nuxt/config'
import tsconfigPaths from 'vite-tsconfig-paths'

export default defineNuxtConfig({
    compatibilityDate: '2025-05-15',
    devtools: { enabled: true },

    runtimeConfig: {
        public: {
            apiBase: 'http://localhost:8000/api/admin',
        },
    },

    css: ['~/assets/css/main.css'],

    modules: ['@pinia/nuxt'],

    plugins: ['~/plugins/api.js'],

    postcss: {
        plugins: {
            '@tailwindcss/postcss': {},
            autoprefixer: {},
        },
    },

    vite: {
        plugins: [
            tsconfigPaths()
        ]
    }
})