// Look into a bower copy/concatenate grunt plugin
// Look into dploy
module.exports = function(grunt) {
	var gc = {};

	/**
	 * SASS Specific Configurations
	 */
	gc.sass = {
		site: {
			options: {
				style: 'compressed',
				sourcemap: true
			},
			files: [{
				expand: true,
				cwd: 'assets/css/scss/site',
				src: ['main.scss'],
				dest: 'assets/css/',
				ext: '.min.css'
			}]
		},
		admin: {
			options: {
				style: 'compressed'
			},
			files: [{
				expand: true,
				cwd: 'assets/css/scss/admin',
				src: ['admin.scss'],
				dest: 'assets/css/',
				ext: '.min.css'
			}]
		}
	};

	/**
	 * JavaScript Specific Configurations
	 */
	gc.uglify = {
		options: { mangle: false },
		site: {
			options:{ sourceMap: 'scripts.min.js.map' },
			files: {
				'assets/js/scripts.min.js': [
					'!assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/plugins.js',
					'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js',
					'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/carousel.js',
					'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js',
					'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/scrollspy.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js',
					// 'assets/bower_components/bootstrap-sass/vendor/assets/javascripts/bootstrap/affix.js',
					// 'assets/bower_components/imagesloaded/imagesloaded.js',
					// 'assets/js/src/plugins/jquery.flexslider.js',
					// 'assets/js/src/plugins/placeholders.jquery.min.js',
					'assets/bower_components/jQuery-ResizeEnd/src/jQuery.resizeEnd.js',
					// 'assets/js/src/plugins/jquery.selectric.js',
					'assets/js/src/plugins/responsive-img.js',
					'assets/js/src/site/ie10-viewport-bug.js',
					'assets/js/src/site/bp.js',
					'assets/js/src/site/scripts.js'
				]
			}
		},
		admin: {
			options:{ sourceMap: 'admin.min.js.map' },
			files: {
				'assets/js/admin.min.js': [
					'assets/js/src/plugins/jquery.cleditor.js',
					'assets/js/src/plugins/chosen.jquery.js',
					'assets/js/src/admin/*.js'
				]
			}
		}
	};

	gc.copy = {
		jsSourceMaps: {
			files: [
				{expand: true, src: ['*.js.map'], dest: 'assets/js/', filter: 'isFile'},
			]
		}
	};

	/**
	 * Image Specific Configurations
	 */
	gc.imagemin = {
		theme: {
			files: [{
				expand: true,
				cwd: 'assets/img/',
				src: ['**/*.{png,jpg,gif}'],
				dest: 'assets/img/'
			}]
		}
	};

	/**
	 * Event Specific Configurations
	 */
	gc.watch = {
		siteSass: {
			files: ['assets/css/scss/site/**/*.scss'],
			tasks: ['sass:site'],
			options: { spawn: false, },
		},
		adminSass: {
			files: ['assets/css/scss/admin/**/*.scss'],
			tasks: ['sass:admin'],
			options: {
				spawn: false,
			},
		},
		siteScripts: {
			files: ['assets/js/src/site/**/*.js'],
			tasks: ['uglify:site', 'copy:jsSourceMaps'],
			options: { spawn: false, },
		},
		adminScripts: {
			files: ['assets/js/src/admin/**/*.js'],
			tasks: ['uglify:admin', 'copy:jsSourceMaps'],
			options: { spawn: false, },
		},
		livereload: {
			options: {
				livereload: true,
				spawn: false,
			},
			files: [
				'assets/css/*.css',
				'assets/js/*.js',
				'**/*.php',
				'!**/node_modules/**',
				'**/*.{png,jpg,gif}'
			],
		},
	};

	// Load Configurations
	grunt.initConfig(gc);


	// Load Tasks
	// This will load all grunt-* tasks that are in the package.json devDependencies
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	// Register Tasks
	grunt.registerTask('default', ['sass']);
	grunt.registerTask('default', ['imagemin']);
};