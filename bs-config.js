module.exports = {
  files: ["./**/*.{html,php,css,js}"],
  proxy: {
    target: "http://a.b",
    ws: true,
  },
  ui: false,
};
//browser-sync start --config bs-config.js
