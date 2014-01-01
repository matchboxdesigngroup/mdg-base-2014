module.exports = function(grunt) {
	// Configurations
	grunt.initConfig({
		// Sass Config
		sass: {
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
		},
		// Concatenate and Uglify JavaScript config
		uglify: {
			options: {
				mangle: false
			},
			site: {
				options:{
					sourceMap: 'scripts.min.js.map'
				},
				files: {
					'assets/js/scripts.min.js': [
						'!assets/js/src/plugins/bootstrap/plugins.js',
						'assets/js/src/plugins/bootstrap/transition.js',
						// 'assets/js/src/plugins/bootstrap/alert.js',
						'assets/js/src/plugins/bootstrap/button.js',
						// 'assets/js/src/plugins/bootstrap/carousel.js',
						'assets/js/src/plugins/bootstrap/collapse.js',
						'assets/js/src/plugins/bootstrap/dropdown.js',
						// 'assets/js/src/plugins/bootstrap/modal.js',
						// 'assets/js/src/plugins/bootstrap/tooltip.js',
						// 'assets/js/src/plugins/bootstrap/popover.js',
						// 'assets/js/src/plugins/bootstrap/scrollspy.js',
						// 'assets/js/src/plugins/bootstrap/tab.js',
						// 'assets/js/src/plugins/bootstrap/affix.js',
						// 'assets/js/src/plugins/imagesloaded.pkgd.js',
						// 'assets/js/src/plugins/jquery.flexslider.js',
						// 'assets/js/src/plugins/placeholders.jquery.min.js',
						'assets/js/src/plugins/jQuery.resizeEnd.js',
						// 'assets/js/src/plugins/jquery.selectric.js',
						'assets/js/src/plugins/responsive-img.js',
						// 'assets/js/src/plugins/waypoints.js',
						'assets/js/src/site/ie10-viewport-bug.js',
						'assets/js/src/site/bp.js',
						'assets/js/src/site/scripts.js'
					]
				}
			},
			admin: {
				options:{
					sourceMap: 'admin.min.js.map',
					sourceMapRoot: 'assets/js/src'
				},
				files: {
					'assets/js/admin.min.js': [
						'assets/js/src/plugins/jquery.cleditor.js',
						'assets/js/src/plugins/chosen.jquery.js',
						'assets/js/src/admin/*.js'
					]
				}
			}
		},
		// JSHint
		jshint: {
			options: {
				reporter: require('jshint-stylish')
			},
			site: ['assets/js/src/admin/*.js'],
			admin: ['assets/js/src/site/*.js']
		},
		// Image Min Config
		imagemin: {
			theme: {
				files: [{
					expand: true,
					cwd: 'assets/img/',
					src: ['**/*.{png,jpg,gif}'],
					dest: 'assets/img/'
				}]
			}
		},
		// Watch Config
		scsslint: {
			site: [
				'assets/css/scss/site/*.scss',
			],
			admin: [
				'assets/css/scss/admin/*.scss',
			],
			options: {
				config: '.scss-lint.yml',
				reporterOutput: null
			},
		},
		watch: {
			siteSass: {
				files: ['assets/css/scss/site/**/*.scss'],
				tasks: ['sass:site', 'scsslint:site'],
				options: {
					spawn: false,
				},
			},
			adminSass: {
				files: ['assets/css/scss/admin/**/*.scss'],
				tasks: ['sass:admin', 'scsslint:admin'],
				options: {
					spawn: false,
				},
			},
			siteScripts: {
				files: ['assets/js/src/site/**/*.js'],
				tasks: [
					'uglify:site',
					'jshint:site'
				],
				options: {
					spawn: false,
				},
			},
			adminScripts: {
				files: ['assets/js/src/admin/**/*.js'],
				tasks: [
					'uglify:admin',
					'jshint:admin'
				],
				options: {
					spawn: false,
				},
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
		}
	});


	// Load Tasks
	// This will load all grunt-* tasks that are in the package.json devDependencies
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	// Register Tasks
	grunt.registerTask('default', ['sass']);
	grunt.registerTask('default', ['imagemin']);
	grunt.registerTask('default', ['jshint']);
	grunt.registerTask('default', ['scsslint']);
};