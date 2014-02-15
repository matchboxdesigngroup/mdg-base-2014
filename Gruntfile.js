module.exports = function(grunt) {
  require('load-grunt-config')(grunt);

	// Load Tasks
	// This will load all grunt-* tasks that are in the package.json devDependencies
	require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

	// Register Tasks
	grunt.registerTask('default', [ 'sass' ]);
	grunt.registerTask('default', [ 'imagemin' ]);
	grunt.registerTask('default', [ 'jshint' ]);
	grunt.registerTask('default', [ 'scsslint' ]);
};
