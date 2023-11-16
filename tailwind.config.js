/** @type {import('tailwindcss').Config} */

const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  important: true,
  content: ["./**/*.php"],
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Be Vietnam Pro"', ...defaultTheme.fontFamily.sans],
      },
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
