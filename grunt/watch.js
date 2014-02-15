module.exports = {
	siteSass: {
		files: [ 'assets/css/scss/site/**/*.scss' ],
		tasks: [
			'sass:site',
			'sass:ltie9'
		],
		options: { spawn: false, },
	},
	adminSass: {
		files: [ 'assets/css/scss/admin/**/*.scss' ],
		tasks: [ 'newer:sass:admin' ],
		options: {
			spawn: false,
		},
	},
	siteScripts: {
		files: [ 'assets/js/src/site/**/*.js' ],
		tasks: [
			'newer:uglify:site',
			'copy:jsSourceMaps'
		],
		options: {
			spawn: false,
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
		files: ['**/*.{png,jpg,gif}'],
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
