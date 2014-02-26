module.exports = {
	siteSass : {
		files : [ 'assets/css/scss/site/**/*.scss' ],
		tasks : [
			'sass:site',
			'group_css_media_queries:site',
			'sass:ltie9',
			'group_css_media_queries:ltie9',
			'autoprefixer',
			'cssmin:site',
			'cssmin:ltie9',
		],
		options : { spawn: false, },
	},
	adminSass : {
		files   : [ 'assets/css/scss/admin/**/*.scss' ],
		tasks   : [
			'sass:admin',
			'group_css_media_queries:admin',
			'autoprefixer',
			'cssmin:admin'
		],
		options : {
			spawn : false,
		},
	},
	siteScripts : {
		files : [ 'assets/js/src/site/**/*.js' ],
		tasks : [
			'newer:uglify:site',
			'copy:jsSourceMaps'
		],
		options : {
			spawn : false,
		},
	},
	adminScripts: {
		files: [ 'assets/js/src/admin/**/*.js' ],
		tasks: [
			'newer:uglify:admin',
			'copy:jsSourceMaps',
		],
		options: { spawn: false, },
	},
	imagemin: {
		files: [ '**/*.{png,jpg,gif}' ],
		tasks: [
			'newer:imagemin',
		],
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
