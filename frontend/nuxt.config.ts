// https://nuxt.com/docs/api/configuration/nuxt-config
// nuxt.config.ts
import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",
  devServer: {
    port: 3001,
    host: "localhost", // or '0.0.0.0' if accessed from network
  },
  devtools: { enabled: true },

  runtimeConfig: {
    public: {
      apiBase: "http://localhost:8001/api",
    },
  },

  css: ["~/assets/css/main.css"],

  vite: {
    plugins: [tailwindcss()],
  },
});
