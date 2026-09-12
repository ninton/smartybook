.PHONY: composer-install
composer-install:
	docker compose run --rm app composer install
