/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  important: true,
  content: ["./src/**/*.php", "./src/**/*.html", "./src/**/*.js"],
  theme: {
    extend: {
      colors: {
        primary: "#3490dc",
        secondary: "#ffed4a",
      },
      extend: {
        fontFamily: {
          'sans': ['"Be Vietnam Pro"', ...defaultTheme.fontFamily.sans],
        },
      },
      fontSize: {
        "7xl": "5rem",
      },
      // ...Thêm các mở rộng khác nếu cần
    },
  },
  variants: {
    extend: {
      backgroundColor: ["active"],
      textColor: ["visited"],
      // ...Thêm các variants khác nếu cần
    },
  },
  plugins: [],
  module: {},
};
