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
        14: "14px",
        11: "11px",
        13: "13px",
      },
      textColor: {
        "se-accent-100": "rgba(44,149,255,1)",
      },
      backgroundColor: {
        "!primary": "rgba(69,29,160,var(--tw-bg-opacity))!important",
        "!primary-100": "rgba(35,9,94,var(--tw-bg-opacity))!important",
      },
      "--tw-bg-opacity": {
        1: "1!important",
        2: "0.5!important", // Thêm các giá trị khác nếu cần
        // ...
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
  specialCharacters: ["!"],
};
