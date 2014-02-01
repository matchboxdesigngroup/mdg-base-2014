#!/usr/bin/env node
var pjson    = require('./package.json');
var program  = require('commander');
var execSync = require('exec-sync');
var _        = require('underscore');
var fs       = require('fs.extra');
var mb       = {
	options : {}
};

// Set program parameters
program
.version(pjson.version)
.option('-init, --init', 'Install required theme dependencies and setup theme.')
.option('-update, --update', 'Update required theme dependencies.')
.parse(process.argv);

// Sets nicer terminal colors
var colors = require('colors');
colors.setTheme({
	silly  : 'rainbow',
	prompt : 'grey',
	info   : 'green',
	data   : 'grey',
	help   : 'cyan',
	warn   : 'yellow',
	debug  : 'blue',
	error  : 'red'
});

/**
 * Asks the user for input through stdin.
 *
 * @param   {String}    optionMsg      The message/question for the option.
 * @param   {String}    defaultOption  The default option to be displayed after the option message.
 * @param   {Function}  callback       Function to execute once complete.
 *
 * @return  {Void}
 */
mb.options.ask = function( optionMsg, defaultOption, callback ) {
	var stdin = process.stdin,
			stdout = process.stdout
	;

	stdin.resume();
	var msg = '';
	if ( defaultOption === '' || typeof defaultOption === 'undefined' ) {
		stdout.write( optionMsg + "*".error + ": " );
	} else if ( defaultOption === null ) {
		stdout.write( optionMsg + ": " );
	} else {
		msg = " (" + defaultOption + ")";
		stdout.write( optionMsg + msg.info + ":" );
	} // if/else()

	stdin.once( 'data', function( data ) {
		data = data.toString().trim();

		if ( defaultOption === '' && data === '' ) {
			var errorMsg = optionMsg + ' is required!';
			console.error( errorMsg.error  );
			mb.options.ask( optionMsg, defaultOption, callback );
		} else {
			if ( typeof callback !== 'undefined' ) {
				callback( data );
			} // if()
		} // if/else()
	});
}; // options.ask()

/**
 * Verify the dependency tools needed.
 *
 * @return  {Boolean}          If all of the tools are installed.
 */
mb.verifyDependencyTools = function() {
	// TODO
	// JSCS
	// JSHint
	// brew --version
	// brew tap
	// CHECK FOR: homebrew/dupes and josegonzalez/php
	// phpcs --version (Also check for https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards )

	var tools = 	{
		grunt    : {
			name    : 'Grunt',
			test    : 'grunt --version',
			info    : 'http://gruntjs.com/',
		},
		bower    : {
			name    : 'Bower',
			test    : 'bower --version',
			info    : 'http://bower.io/',
		},
		composer : {
			name    : 'Composer',
			test    : 'composer --version',
			info    : 'https://getcomposer.org/',
		},
		ruby     : {
			name    : 'Ruby',
			test    : 'ruby --version',
			info    : 'http://rvm.io/',
		},
		sass     : {
			name    : 'SASS',
			test    : 'sass --version',
			info    : 'http://sass-lang.com/',
		},
		scsslint : {
			name    : 'SCSS-Lint',
			test    : 'scss-lint --version',
			info    : 'https://github.com/causes/scss-lint',
		},
	};

	var toolsNotInstalled = [];

	_.each(tools, function(value, key, list) {
		console.log('Verifying dependency: ' + value.name);
		var msg          = '';
		var verification = execSync(value.test, true);

		if ( verification.stderr === '' ) {
			console.log(verification.stdout.info);
		} else {
			msg = value.name + ' is not installed!',
			console.error(msg.error + ' Please visit ' + value.info + ' for more information.');
			toolsNotInstalled.push(value.name);
		} // if/else()
		console.log('');
	});

	if ( toolsNotInstalled.length === 0 ) {
		return true;
	} // if()
	msg = '**Please install ' + toolsNotInstalled.join() + ' before continuing**';
	console.error(msg.error);

	console.log();
	console.log('exiting');
	process.exit();

	return false;
};

/**
 * Asks for the theme name.
 *
 * @param   {Function}  callback  Function to execute when complete.
 *
 * @return  {Void}
 */
mb.askThemeName = function(callback) {
	mb.options.ask('Theme Name', null, function(data) {
		var themeName = data;

		mb.options.ask(themeName + ' are you sure? [Y/N]', 'Y', function(data){
			if (data.toLowerCase() === 'y' || data === '') {
				mb.themeName = themeName;
				callback();
			} else {
				mb.askThemeName(callback);
			} // if/else()
		});
	});
};

/**
 * Update the theme dependencies.
 *
 * @return  {Void}
 */
mb.update = function() {
	process.chdir('../');

	// Grunt NPM
	console.log('Installing Grunt tasks from NPM (May take awhile)');
	var npmInstall = execSync('npm install', true);
	console.log(npmInstall.stdout.info);
	console.log(npmInstall.stderr.error);
	console.log('');

	// Bower
	console.log('Updating Bower components. (May take awhile)');
	process.chdir('assets/');
	var bowerUpdate = execSync('bower update', true);
	console.log(bowerUpdate.stdout.info);
	console.log(bowerUpdate.stderr.error);
	console.log('');

	// Composer/WP Plugins
	console.log('Moving composer.json');
	process.chdir('../');

	fs.copy('composer.json', '../../../composer.json', function (err) {
		if (err) {
			throw err;
		} // if()

		console.log('Moved composer.json'.info);

		process.chdir('../../../');

		console.log('Installing WordPress plugins and Composer dependencies.');
		var composerUpdate = execSync( 'composer update', true );
		console.log(composerUpdate.stdout.info);
		console.log(composerUpdate.stderr.error);
		console.log('');
		console.log('Complete, exiting'.info);
		process.exit();
	});
};

/**
 * Initializes the theme.
 *
 * @return  {Void}
 */
mb.init = function() {
	mb.verifyDependencyTools();

	mb.askThemeName(function(){
		mb.update()
	});
};

// Give help documentation since nothing was passed
if ( program.rawArgs.length < 3 ) {
	var getHelp = execSync('./index.js --help', true);
	console.log(getHelp.stdout);
	process.exit();
} // if()

if (program.init) {
	mb.init();
};
if (program.update){
	mb.update();
};

// Node
// 	JSHint
// 	JSCS
// PHP