/** @type {import('tailwindcss').Config} */
// const defaultTheme = require('tailwindcss/defaultTheme')

export default {
  content: [
    "./resources/css/**/*.css",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
    "./app/View/Components/**/*.php",
    "./vendor/laravel/**/*.blade.php",
    "./app/Highlighter/ConsoleTokenTypeEnum.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        // sans: ['Inter var', ...defaultTheme.fontFamily.sans],
        'mono': ['"JetBrains Mono"'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require("@tailwindcss/typography"),
    require("@tailwindcss/aspect-ratio"),
    require('@tailwindcss/container-queries'),
  ],
}

