#! /bin/sh
echo "\nInstalling NPM modules for Grunt.js.";
cd ../;
npm update;

# echo "\nLinking Git Hooks."
# ln -s dev-assets/pre-commit.sh .git/hooks/pre-commit

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