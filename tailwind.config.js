/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './components/**/*.{js,vue,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './composables/**/*.{js,ts}',
    './plugins/**/*.{js,ts}',
    './app.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['"Roboto Condensed"', 'Impact', 'sans-serif'],
        price: ['Anton', '"Roboto Condensed"', 'Impact', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

