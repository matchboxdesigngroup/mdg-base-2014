#! /bin/sh
echo "\nInstalling NPM modules for Grunt.js.";
cd ../;
npm install;

echo "\nUpdating Bower components."
cd assets/;
bower update;

echo "\nUpdating theme Composer requirements";
cd ../;
composer update

echo "\nInstalling development WordPress plugins"
cp dev-assets/composer-plugins.json ../../../composer.json;
cd ../../../;
composer update;