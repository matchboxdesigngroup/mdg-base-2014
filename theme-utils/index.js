#!/usr/bin/env node
var pjson    = require('./package.json');
var program  = require('commander');
var execSync = require('exec-sync');
var _        = require('underscore');
var fs       = require('fs.extra');
var mb       = {
	options: {}
};

// Set program parameters
program
.version(pjson.version)
.option('-init, --init', 'Install required theme dependencies and setup theme.')
// .option('-update, --update', 'Update required theme dependencies.')
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
 * Allows for uppercasing of the first letter in every word like PHP ucfirst()
 *
 * @return  {string}  The new uppercase.
 */
String.prototype.ucfirst = function () {
	// Split the string into words if string contains multiple words.
	var x = this.split(/\s+/g);

	for (var i = 0; i < x.length; i++) {

			// Splits the word into two parts. One part being the first letter,
			// second being the rest of the word.
			var parts = x[i].match(/(\w)(\w*)/);

			// Put it back together but uppercase the first letter and
			// lowercase the rest of the word.
			x[i] = parts[1].toUpperCase() + parts[2].toLowerCase();
	}

	// Rejoin the string and return.
	return x.join(' ');
};

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
	// brew --version
	// brew tap
	// CHECK FOR: homebrew/dupes and josegonzalez/php
	// phpcs --version (Also check for https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards )

	var tools = 	{
		grunt: {
			name : 'Grunt',
			test : 'grunt --version',
			info : 'http://gruntjs.com/getting-started',
		},
		jshint: {
			name : 'JSHint',
			test : 'jshint',
			info : 'http://www.jshint.com/install/',
		},
		jscs: {
			name : 'JSCS',
			test : 'jscs --version',
			info : 'https://github.com/mdevils/node-jscs#installation',
		},
		bower : {
			name : 'Bower',
			test : 'bower --version',
			info : 'http://bower.io/#installing-bower',
		},
		composer : {
			name : 'Composer',
			test : 'composer --version',
			info : 'https://getcomposer.org/download/',
		},
		ruby : {
			name : 'Ruby',
			test : 'ruby --version',
			info : 'http://rvm.io/rvm/install',
		},
		sass : {
			name : 'SASS',
			test : 'sass --version',
			info : 'http://sass-lang.com/install',
		},
		scsslint : {
			name : 'SCSS-Lint',
			test : 'scss-lint --version',
			info : 'https://github.com/causes/scss-lint#installation',
		},
	};

	var toolsNotInstalled = [];

	_.each(tools, function(value, key, list) {
		console.log('Verifying dependency: ' + value.name);
		var msg          = '';
		var verification = execSync(value.test, true);

		if ( verification.stderr === '' ) {
			if ( value.name.toLowerCase() === 'jshint' ) {
				// JSHint prints the version information to STD Error instead of STD Out
				var jshintVersion = execSync('jshint --version', true);
				console.log(jshintVersion.stderr.info);
			} else {
				console.log(verification.stdout.info);
			}
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

	console.log('');
	console.log('exiting');
	process.exit();

	return false;
};

/**
 * Rename Theme Directory
 *
 * @param   {Function}  callback  Function to execute when complete.
 *
 * @return  {Void}
 */
mb.renameThemeDirectory = function(callback) {
	console.log('');
	console.log('Renaming theme directory...');
	var startThemeDirectoryPath = process.cwd();
	process.chdir('../');
	var startThemeParentPath = process.cwd();
	var startThemeName = startThemeDirectoryPath.replace(startThemeParentPath, '').replace('/', '');
	fs.renameSync( startThemeName, mb.themeSlug);
	console.log('Theme directory renamed'.info);
	callback();
};

/**
 * Rename Theme in style.css
 *
 *
 * @param   {Function}  callback  Function to execute when complete.
 *
 * @return  {Void}
 */
mb.renameThemeStyleCSS = function(callback) {
	process.chdir(mb.themePath);

	var styleCSS       = 'style.css';
	var styleCSSExists = fs.existsSync( styleCSS );
	console.log('');
	if ( !styleCSSExists ) {
		console.log('You are missing a style.css in your theme directory are you sure this is a valid WordPress Theme?'.error);
		console.log('Please add a style.css before attempting to activate the theme'.warn);
		callback();
	} // if()

	console.log('Renaming theme...');
	var styleCssLines = fs.readFileSync(styleCSS).toString().split('\n');

	for(var i in styleCssLines) {
		var line = styleCssLines[i];

		if ( line.indexOf('Theme Name:') !== -1 ) {
			styleCssLines[i] = 'Theme Name:         ' + mb.themeName;
		} else {
			styleCssLines[i] = line;
		} // if/else()
	} // for()

	fs.writeFileSync( styleCSS, styleCssLines.join('\n') );

	console.log('Theme renamed'.info);

	callback();
};

/**
 * Asks for the theme name.
 *
 * @param   {Function}  callback  Function to execute when complete.
 *
 * @return  {Void}
 */
mb.askThemeName = function(callback) {
	var askThemeNameCallback = callback;
	mb.options.ask('Theme Name', null, function(data) {
		var themeName = data;

		mb.options.ask('Your theme will be named ' + themeName + ' are you sure? [Y/N]', 'Y', function(data){
			if (data.toLowerCase() === 'y' || data === '') {
				// Set theme name
				mb.themeName = themeName.ucfirst();
				mb.themeSlug = themeName.toLowerCase().replace(/\W/g, ' ').replace(/\s+/g, '-');

				// Set theme path info
				var currentDirectory = process.cwd();
				process.chdir('../../');
				mb.themeBasePath = process.cwd();
				mb.themePath =  mb.themeBasePath + '/' + mb.themeSlug;
				process.chdir(currentDirectory);
				process.chdir('../');

				mb.renameThemeDirectory(function(){
					mb.renameThemeStyleCSS(function() {
						askThemeNameCallback();
					});
				});
			} else {
				console.log('');
				mb.askThemeName(askThemeNameCallback);
			} // if/else()
		});
	});
};

/**
 * Handles install/updating of composer dependencies and WordPress plugins.
 *
 * @todo    Write the name/description to composer.json before moving.
 *
 * @param   {Function}  callback       Function to execute once complete.
 *
 * @return  {Void}
 */
mb.composerInstallUpdate = function(callback) {
	process.chdir(mb.themePath);

	var cjsonExists = fs.existsSync('../../../composer.json');
	if ( cjsonExists ) {
		process.chdir('../../../');

		console.log('Installing WordPress plugins and Composer dependencies... (This may take awhile)');
		var composerUpdate = execSync( 'composer update', true );
		console.log(composerUpdate.stdout.info);
		console.log(composerUpdate.stderr.error);
		console.log('');
		process.chdir(mb.themePath);
		callback();
	} else {
		console.log('Moving composer.json...');
		fs.copy('composer.json', '../../../composer.json', function (err) {
			if (err) {
				throw err;
			} // if()

			console.log('Moved composer.json'.info);

			process.chdir('../../../');

			console.log('Installing WordPress plugins and Composer dependencies... (This may take awhile)');
			var composerUpdate = execSync( 'composer update', true );
			console.log(composerUpdate.stdout.info);
			console.log(composerUpdate.stderr.error);
			process.chdir(mb.themePath);
			callback();
		}); // fs.copy()
	} // if/else()
};

/**
 * Handles install/updating of NPM modules.
 *
 * @todo     Write name to package.json before installing NPM modules.
 *
 * @param   {Function}  callback       Function to execute once complete.
 *
 * @return  {Void}
 */
mb.npmInstallUpdate = function(callback) {
	process.chdir(mb.themePath);
	console.log('Installing Grunt tasks from NPM... (This may take awhile)');
	var nodeModulesExists = fs.existsSync('node_modules');
	var npmInstall;
	if ( nodeModulesExists ) {
		npmInstall = execSync('npm install', true);
	} else {
		npmInstall = execSync('npm update', true);
	} // if/else()

	console.log(npmInstall.stdout.info);
	console.log(npmInstall.stderr.error);
	console.log('');
	callback();
};

/**
 * Handles install/updating of bower.
 *
 * @param   {Function}  callback       Function to execute once complete.
 *
 * @return  {Void}
 */
mb.bowerInstallUpdate = function(callback) {
	console.log('');
	console.log('Updating Bower components... (This may take awhile)');
	process.chdir(mb.themePath + '/assets/');
	var bowerUpdate = execSync('bower update', true);
	console.log(bowerUpdate.stdout.info);
	console.log(bowerUpdate.stderr.error);
	console.log('');
	process.chdir(mb.themePath);
	callback();
}

/**
 * Handles exiting and any useful information
 *
 * @return  {Void}
 */
mb.updateComplete = function() {
	console.log('');
	console.log('*************************');
	console.log('NOTES')
	console.log('*************************');
	var themeScrenShot = '• You should update the theme screenshot ('+mb.themePath+'/screenshot.png)';
	console.log(themeScrenShot.warn);
	var pathToRcFile = '• You may want to add alias '+mb.themeSlug+'="cd '+mb.themePath+'" to your .bashrc or .zshrc.';
	console.log(pathToRcFile.info);
	var gruntWatch = '• Run grunt watch in ' + mb.themePath + ' to get started.';
	console.log(gruntWatch.info);
	console.log('');
	process.chdir(mb.themePath);
	console.log('Complete, exiting'.info);
	process.exit();
};

mb.moveGitHooks = function(callback) {
	process.chdir(mb.themePath);
// ln -s ../../pre-commit.sh .git/hooks/pre-commit
	var precommitExists = fs.existsSync('pre-commit.sh');
	if ( !precommitExists ) {
		callback();
	} // if()

	var gitHooksExist = fs.existsSync('.git/hooks/');
	if ( !gitHooksExist ) {
		process.chdir('../');

		// Check again
		gitHooksExist = fs.existsSync('.git/hooks/');
		if ( !gitHooksExist ) {
			console.log('');
			console.log('There is no GIT repository available, pre-commit hooks can not be installed.'.warn);
			callback();
		} // if()
	} // if()

	process.chdir(mb.themePath);

	console.log('');
	console.log('Linking '+process.cwd()+'/pre-commit.sh to '+process.cwd()+'/.git/hooks/pre-commit...');
	var gitHooksPrecommitExists = fs.existsSync(process.cwd()+'/.git/hooks/pre-commit');

	if ( gitHooksPrecommitExists ) {
		var hooksExistMsg = 'Pre-commit hook already exists in ' + process.cwd()+'/.git/hooks/pre-commit.';
		console.log(hooksExistMsg.warn);
		var notLinkedMSg = 'Pre-commit hook '+process.cwd()+'/pre-commit.sh not linked to '+process.cwd()+'/.git/hooks/pre-commit...';
		console.log(notLinkedMSg.warn);
		callback();
	} // if()

	var symLinkGitHooks = execSync('ln -s '+mb.themePath+'/pre-commit.sh '+process.cwd()+'/.git/hooks/pre-commit', true);

	if ( symLinkGitHooks.stderr === '') {
		var linkedMSg = 'Pre-commit hook '+process.cwd()+'/pre-commit.sh linked to '+process.cwd()+'/.git/hooks/pre-commit...';
		console.log(linkedMSg.info);
	} else {
		console.log(notLinkedMSg.error);
	} // if/else()

	callback();
};

/**
 * Update the theme dependencies.
 *
 * @return  {Void}
 */
mb.update = function() {
	process.chdir('../');

	mb.moveGitHooks(function(){
		mb.bowerInstallUpdate(function(){
			mb.composerInstallUpdate(function(){
				mb.npmInstallUpdate(function(){
					mb.updateComplete();
				}); // mb.npmInstallUpdate()
			}); // mb.npmInstallUpdate()
		}); // mb.composerInstallUpdate()
	}); // mb.moveGitHooks()
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