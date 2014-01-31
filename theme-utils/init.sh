#! /bin/sh
####################################################
# Full Requirements
# Node
# 	Grunt
# 	bower
# 	JSHint
# 	JSCS
# Ruby
# 	Sass
# 	scss-lint
# Composer
#
####################################################
echo "Installing NPM modules for Grunt.js.";
npm install;
echo "Updating Bower components."
cd assets/;
bower update;
echo "Moving composer.json"
cd ../;
cp composer.json ../../../composer.json;
cd ../../../;
composer update;