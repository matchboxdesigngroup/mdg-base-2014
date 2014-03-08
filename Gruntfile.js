module.exports = function(grunt) {
	// Measures the time each task takes
	require('time-grunt')(grunt);

	// Load Grunt Configurations
	require('load-grunt-config')(grunt);

	// Load Tasks
	// This will load all grunt-* tasks that are in the package.json devDependencies
	require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

	// Register Tasks
	grunt.registerTask('default', [ 'watch' ]);
	grunt.registerTask('conflict', [ 'sass:site', 'sass:ltie9', 'uglify:site' ]);
	grunt.registerTask('build', [ 'sass', 'imagemin', 'uglify:build', 'autoprefixer', 'group_css_media_queries', 'cssmin' ]);
};
