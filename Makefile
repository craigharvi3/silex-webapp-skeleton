.PHONY: dev-install phpunit build-assets

# Install composer and npm dependencies
dev-install:
	composer install
	npm install

# Run PHPUnit tests
phpunit:
	vendor/bin/phpunit

#
# ----------- Build -----------
#

# Build front end code and run tests
build-assets:
	node_modules/gulp/bin/gulp.js ci
