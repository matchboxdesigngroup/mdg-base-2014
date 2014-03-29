module.exports =
	admin:
		expand: true
		cwd: "assets/css/dist/"
		src: ["admin.min.css"]
		dest: "assets/css/dist"
		ext: ".min.css"

	site:
		expand: true
		cwd: "assets/css/dist/"
		src: ["main.*.min.css"]
		dest: "assets/css/dist"
		ext: ".min.css"

	ltie9:
		expand: true
		cwd: "assets/css/dist/"
		src: ["main-ltie9.*.min.css"]
		dest: "assets/css/dist"
		ext: ".min.css"