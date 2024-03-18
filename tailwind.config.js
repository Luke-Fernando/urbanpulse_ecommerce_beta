// @type {import('tailwindcss').Config}
module.exports = {
  content: ["./*.php", "./**/*.php", "./assets/js/*.js", "./assets/js_beta/*.js", "./*.js", "./**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [
    require("flowbite/plugin")({
      charts: true,
    }),
  ],
};
