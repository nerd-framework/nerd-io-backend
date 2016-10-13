install:
	composer install --prefer-dist

lint:
	composer exec 'phpcs --standard=PSR2 src tests'

test:
	composer exec phpunit -- --color tests