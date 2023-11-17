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
      fontSize: {
        '14': '14px',
      },
      textColor: {
        'se-accent-100': 'rgba(44,149,255,1)',
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
