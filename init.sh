#! /bin/sh
echo "Installing NPM modules for Grunt.js.";
npm install;

echo "Updating Bower components."
cd assets/;
bower update;

echo "Updating theme Composer requirements";
composer update

echo "Installing WordPress plugins"
cd ../;
cp composer-plugins.json ../../../composer.json;
cd ../../../;
composer update;