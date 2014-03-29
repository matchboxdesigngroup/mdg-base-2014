module.exports =
  assets:
    options:
      algorithm: "sha1"
      length: 4
      format: false
      rename: true

    files:
      "lib/scripts.php": [
        "assets/js/dist/env-tests.min.js"
        "assets/js/dist/admin.min.js"
        "assets/js/dist/scripts.min.js"
        "assets/css/dist/admin.min.css"
        "assets/css/dist/main-ltie9.min.css"
        "assets/css/dist/main.min.css"
      ]