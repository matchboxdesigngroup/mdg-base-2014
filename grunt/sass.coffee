module.exports =
  site:
    options:
      style: "compressed"
      sourcemap: true

    files: [
      expand: true
      cwd: "assets/css/scss/site"
      src: ["main.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]

  siteBuild:
    options:
      style: "compressed"
      sourcemap: false

    files: [
      expand: true
      cwd: "assets/css/scss/site"
      src: ["main.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]


  ltie9:
    options:
      style: "compressed"
      sourcemap: true

    files: [
      expand: true
      cwd: "assets/css/scss/site"
      src: ["main-ltie9.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]

  ltie9Build:
    options:
      style: "compressed"
      sourcemap: false

    files: [
      expand: true
      cwd: "assets/css/scss/site"
      src: ["main-ltie9.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]

  admin:
    options:
      style: "compressed"
      sourcemap: true

    files: [
      expand: true
      cwd: "assets/css/scss/admin"
      src: ["admin.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]

  adminBuild:
    options:
      style: "compressed"
      sourcemap: false

    files: [
      expand: true
      cwd: "assets/css/scss/admin"
      src: ["admin.scss"]
      dest: "assets/css/"
      ext: ".min.css"
    ]