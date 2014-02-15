module.exports = function(grunt) {
	// Measures the time each task takes
  require('time-grunt')(grunt);

	// Load Grunt Configurations
  require('load-grunt-config')(grunt);

	// Load Tasks
	// This will load all grunt-* tasks that are in the package.json devDependencies
	require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

	// Register Tasks
	grunt.registerTask('default', [ 'newer:sass' ]);
	grunt.registerTask('default', [ 'newer:imagemin' ]);
	grunt.registerTask('default', [ 'newer:jshint' ]);
	grunt.registerTask('default', [ 'newer:scsslint' ]);
};
