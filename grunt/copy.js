module.exports = {
	jsSourceMaps: {
		files: [
			{ expand: true, src: ['*.js.map'], dest: 'assets/js/', filter: 'isFile'},
		]
	}
};
