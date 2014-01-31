#!/usr/bin/env node
var pjson = require('./package.json');
var program = require('commander');
var execSync = require('exec-sync');
var mb = {
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
 * @param   {Array}    tools  The tool command to execute to test.
 *
 * @return  {Boolean}          If all of the tools are installed.
 */
mb.verifyDependencyTools = function(tools) {
	// grunt --version
	// bower --version
	// composer --version
	// ruby --version
	// sass --version
	// scss-lint --version
	// brew --version
	// brew tap
	// CHECK FOR: homebrew/dupes and josegonzalez/php
	// phpcs --version (Also check for https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards )
};

/**
 * Initializes the theme.
 *
 * @return  {Void}
 */
mb.init = function() {
	mb.options.ask( 'Theme Name' );
};

/**
 * Update the theme dependencies.
 *
 * @return  {Void}
 */
mb.update = function() {
	mb.options.ask( 'Theme Name' );
};

// Give help documentation since nothing was passed
if ( program.rawArgs.length < 3 ) {
	var getHelp = execSync('./index.js --help', true);
	console.log(getHelp.stdout);
	process.exit();
} // if()

if (program.init) {
	mb.init();
	mb.verifyDependencyTools();
};
if (program.update){
	mb.update();
};

// Node
// 	JSHint
// 	JSCS
// PHP