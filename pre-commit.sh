#!/bin/sh
#
# Pre-commit hooks

# ADD to init.sh ln -s ../../pre-commit.sh .git/hooks/pre-commit
# Rewrite theme path

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

######################################################################
# JSHint: Lint stuff before committing
######################################################################
grunt jshint
EXIT_CODE=$?
# echo ${EXIT_CODE}
if [[ ${EXIT_CODE} -ne 0 ]]; then
    echo "[ERRROR] code = " ${EXIT_CODE}
    echo "JSHint detected syntax problems."
    echo "Commit aborted."
    exit 1
else
	echo "JSHint completed successfully\n"
fi

grunt jscs
EXIT_CODE=$?
# echo ${EXIT_CODE}
if [[ ${EXIT_CODE} -ne 0 ]]; then
    echo "[ERRROR] code = " ${EXIT_CODE}
    echo "JSCS detected syntax problems."
    echo "Commit aborted."
    exit 1
else
	echo "JSCS completed successfully\n"
fi

grunt scsslint
EXIT_CODE=$?
# echo ${EXIT_CODE}
if [[ ${EXIT_CODE} -ne 0 ]]; then
    echo "[ERRROR] code = " ${EXIT_CODE}
    echo "SCSS-Lint detected syntax problems."
    echo "Commit aborted."
    exit 1
else
	echo "SCSS-Lint completed successfully\n"
fi

# Run PHPCS
grunt phpcs
EXIT_CODE=$?
# echo ${EXIT_CODE}
if [[ ${EXIT_CODE} -ne 0 ]]; then
    echo "[ERRROR] code = " ${EXIT_CODE}
    echo "PHPCS detected syntax problems."
    echo "Commit aborted."
    exit 1
else
	echo "PHPCS completed successfully\n"
fi

#Look for debugger statements
FILES_PATTERN='\.(js|coffee)(\..+)?$'
FORBIDDEN='console.log'
git diff --cached --name-only | \
    grep -E $FILES_PATTERN | \
    GREP_COLOR='4;5;37;41' xargs grep --color --with-filename -n $FORBIDDEN && echo 'COMMIT REJECTED Found "$FORBIDDEN" references. Please remove them before commiting' && exit 1

exit 0