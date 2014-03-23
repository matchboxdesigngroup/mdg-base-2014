module.exports =
  siteSass:
    files: ["assets/css/scss/site/**/*.scss"]
    tasks: [
      "sass:site"
      "group_css_media_queries:site"
      "sass:ltie9"
      "group_css_media_queries:ltie9"
      "autoprefixer"
      "cssmin:site"
      "cssmin:ltie9"
    ]
    options:
      spawn: false

  adminSass:
    files: ["assets/css/scss/admin/**/*.scss"]
    tasks: [
      "sass:admin"
      "group_css_media_queries:admin"
      "autoprefixer"
      "cssmin:admin"
    ]
    options:
      spawn: false

  siteScripts:
    files: ["assets/js/src/site/**/*.js"]
    tasks: [
      "uglify:site"
      "copy:jsSourceMaps"
    ]
    options:
      spawn: false

  envScripts:
    files: ["assets/js/src/env/**/*.js"]
    tasks: [
      "uglify:env"
      "copy:jsSourceMaps"
    ]
    options:
      spawn: false

  adminScripts:
    files: ["assets/js/src/admin/**/*.js"]
    tasks: [
      "uglify:admin"
      "copy:jsSourceMaps"
    ]
    options:
      spawn: false

  imageoptim:
    files: [
      "**/*.{png,jpg,gif}"
      "!assets/img/sprite/**/*.{png,jpg,gif}"
      "!assets/img/sprite.png"
    ]
    tasks: ["imageoptim:all"]
    options:
      spawn: false

  sprite:
    files: ["assets/img/sprite/**/*.{png,jpg,gif}"]
    tasks: ["imageoptim:sprite", "sprite"]
    options:
      spawn: false

  phpdoc:
    files: [
      "lib/**/*.php",
      "classes/**/*.php"
    ]
    tasks: ["phpdoc"]
    options:
      spawn: false

  livereload:
    options:
      livereload: true
      spawn: false

    files: [
      "assets/css/*.css"
      "assets/js/*.js"
      "**/*.php"
      "!**/node_modules/**"
      "**/*.{png,jpg,gif}"
    ]