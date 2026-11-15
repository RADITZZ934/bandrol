// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-02-01',
  devtools: { enabled: false },
  modules: ['@pinia/nuxt', '@nuxtjs/tailwindcss'],
  css: ['~/assets/css/tailwind.css'],
  ssr: false,
  devServer: {
    port: 5000,
  },
  app: {
    baseURL: '/bandrol/',
    head: {
      title: 'Bandrol Maker — Laskar & Bazzar',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
      link: [
        {
          rel: 'icon',
          type: 'image/png',
          href: '/bram.png',
        },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&family=Roboto+Condensed:wght@700;900&display=swap',
        },
      ],
    },
  },
})

