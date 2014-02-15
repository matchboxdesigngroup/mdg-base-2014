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

echo "\nLinking up JSCS configuration files";
ln -s .jscs.json assets/js/src/site/.jscs.json;
ln -s .jscs.json assets/js/src/admin/.jscs.json;

echo "\nInstalling development WordPress plugins"
cp dev-assets/composer-plugins.json ../../../composer.json;
cd ../../../;
composer update;