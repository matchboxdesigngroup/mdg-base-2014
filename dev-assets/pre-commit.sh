#!/bin/bash
#
# Pre-commit hooks

######################################################################
# Environment Setup
# 1) Change directory to build dir so we can run grunt tasks.
# 2) Make sure path is extended to include grunt task executable
#    dir, as this commit shell is executed in the git
#    client's own shell; ie Tower and WebStorm have own shell path.
######################################################################
cd /Applications/MAMP/htdocs/mdg-base/wp-content/themes/mdg-base

PATH=$PATH:~/usr/local/bin
PATH=$PATH:/usr/local/bin
PATH=$PATH:$HOME/.rvm/gems/
[[ -s "$HOME/.rvm/scripts/rvm" ]] && source "$HOME/.rvm/scripts/rvm"

echo ""
echo "#### Running JSHint ####"
echo ""
grunt jshint
EXIT_CODE=$?
if [[ ${EXIT_CODE} -ne 0 ]]; then
	echo "**** JSHint detected syntax problems. ****"
	echo "**** Commit aborted. ****"
	exit 1
else
	echo ""
	echo "#### JSHint completed successfully ####"
	echo ""
fi

# grunt jscs
# EXIT_CODE=$?
# # echo ${EXIT_CODE}
# if [[ ${EXIT_CODE} -ne 0 ]]; then
#     echo "[ERRROR] code = " ${EXIT_CODE}
#     echo "JSCS detected syntax problems."
#     echo "Commit aborted."
#     exit 1
# else
# 	echo "JSCS completed successfully"
# fi

echo ""
echo "#### Running SCSS-Lint ####"
echo ""
grunt scsslint
EXIT_CODE=$?
if [[ ${EXIT_CODE} -ne 0 ]]; then
	echo "**** SCSS-Lint detected syntax problems. ****"
	echo "**** Commit aborted. ****"
	exit 1
else
	echo ""
	echo "#### SCSS-Lint completed successfully ####"
	echo ""
fi

# Run PHPCS
# grunt phpcs
# EXIT_CODE=$?
# # echo ${EXIT_CODE}
# if [[ ${EXIT_CODE} -ne 0 ]]; then
#     echo "[ERRROR] code = " ${EXIT_CODE}
#     echo "PHPCS detected syntax problems."
#     echo "Commit aborted."
#     exit 1
# else
# 	echo "PHPCS completed successfully"
# fi