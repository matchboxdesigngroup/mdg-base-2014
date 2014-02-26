module.exports = {
	dev : {
		bsFiles : {
			src : [
				'*.css',
				'*.php',
				'/assets/img/**/*',
				'*.min.js'
			]
		},
		options : {
			watchTask : false,
			proxy : {
				// Your existing vhost setup
				host: 'mdg-base.dev'
			}
		}
	}
};
