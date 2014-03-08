module.exports =
  theme:
    files: [
      cache: false
      expand: true
      cwd: "assets/"
      src: ["assets/img/**/*.{png,jpg,gif}"]
      dest: "assets/"
    ]
  bower:
    files: [
      cache: false
      expand: true
      cwd: "assets/"
      src: ["assets/bower_components/**/*.{png,jpg,gif}"]
      dest: "assets/"
    ]