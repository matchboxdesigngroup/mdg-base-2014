module.exports =
	all:
		options:
			jpegMini: false
			imageAlpha: true
			quitAfter: true
		src: [
			"assets/img/**/*.{png,jpg,gif}"
			"assets/bower_components/**/*.{png,jpg,gif}"
			"!assets/img/sprite.png"
			"!assets/img/sprite/**/*.{png,jpg,gif}"
		]
	sprite:
		options:
			jpegMini: false,
			imageAlpha: true,
			quitAfter: true
		src: ["assets/img/sprite.png"]