module.exports =
  options:
    mangle: false

  site:
    options:
      sourceMap: "scripts.min.js.map"

    files:
      "assets/js/scripts.min.js": [
        "!assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/plugins.js"
        "assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js"
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js',
        "assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js"
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js',
        "assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js"
        "assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js"
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js',
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js',
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js',
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js',
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js',
        # 'assets/bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js',
        # 'assets/bower_components/imagesloaded/imagesloaded.js',
        # 'assets/js/src/plugins/jquery.flexslider.js',
        # 'assets/bower_components/jquery-placeholder/jquery.placeholder.js',
        "assets/bower_components/jQuery-ResizeEnd/src/jQuery.resizeEnd.js"
        # 'assets/bower_components/jquery-selectric/js/jquery.selectric.js',
        "assets/bower_components/fitvids/jquery.fitvids.js"
        # "assets/js/src/plugins/responsive-img.js"
        "assets/js/src/site/ie10-viewport-bug.js"
        "assets/js/src/site/bp.js"
        "assets/js/src/site/scripts.js"
      ]

  env:
    options:
      sourceMap: "env-tests.min.js.map"

    files:
      "assets/js/env-tests.min.js": [
        "assets/js/src/env/modernizr**.js"
        "assets/bower_components/devicejs/lib/device.min.js"
      ]

  admin:
    options:
      sourceMap: "admin.min.js.map"

    files:
      "assets/js/admin.min.js": [
        "assets/js/src/plugins/jquery.cleditor.js"
        "assets/js/src/plugins/chosen.jquery.js"
        "assets/js/src/admin/*.js"
      ]

  build:
    files:
      "assets/js/scripts.min.js": "assets/js/scripts.min.js"
      "assets/js/admin.min.js": "assets/js/admin.min.js"
      "assets/js/env-tests.min.js" : "assets/js/env-tests.min.js"