/*
 |--------------------------------------------------------------------------
 | Browser-sync config file
 |--------------------------------------------------------------------------
 |
 | Please report any issues you encounter:
 |  https://github.com/shakyShane/browser-sync/issues
 |
 | For up-to-date information about the options:
 |  https://github.com/shakyShane/browser-sync/wiki/Working-with-a-Config-File
 |
 */
module.exports = {

	/*
	|--------------------------------------------------------------------------
	| Files to watch
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-files
	*/
	files: [
		'*.css',
		'*.php',
		'/assets/img/**/*',
		'*.min.js'
	],

	/*
	|--------------------------------------------------------------------------
	| Directories or files to exclude
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-exclude
	*/
	exclude : false,

	/*
	|--------------------------------------------------------------------------
	| Proxy
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-proxy
	*/
	proxy : {
		host : 'mdg-base.dev'
	},

	/*
	|--------------------------------------------------------------------------
	| Start path
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-startPath
	*/
	startPath: null,

	/*
	|--------------------------------------------------------------------------
	| Ghost Mode
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-ghostmode
	*/
	ghostMode: {
		clicks : true,
		links  : true,
		forms  : true,
		scroll : true
	},

	/*
	|--------------------------------------------------------------------------
	| Open (true|false)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-open
	*/
	open : true,

	/*
	|--------------------------------------------------------------------------
	| Timestamps (true|false)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-timestamps
	*/
	timestamps : true,

	/*
	|--------------------------------------------------------------------------
	| File Timeout (milliseconds)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-filetimeout
	*/
	fileTimeout: 1000,

	/*
	|--------------------------------------------------------------------------
	| Inject Changes
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-injectchanges
	*/
	injectChanges: true,

	/*
	|--------------------------------------------------------------------------
	| Scroll Proportionally (true|false)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-scrollproportionally
	*/
	scrollProportionally: true,

	/*
	|--------------------------------------------------------------------------
	| Scroll Throttle (milliseconds)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-scrollthrottle
	*/
	scrollThrottle: 0,

	/*
	|--------------------------------------------------------------------------
	| Notify (true|false)
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-notify
	*/
	notify: true,

	/*
	|--------------------------------------------------------------------------
	| Excluded File Types
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-excludedfiletypes
	*/
	excludedFileTypes: [],

	/*
	|--------------------------------------------------------------------------
	| Reload Delay
	|--------------------------------------------------------------------------
	| https://github.com/shakyShane/browser-sync/wiki/options#wiki-reloadDelay
	*/
	reloadDelay: 0

};
