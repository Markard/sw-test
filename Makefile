install-dev: ## Install project for development
	cp docker/php-fpm/xdebug/xdebug.ini.example docker/php-fpm/xdebug/xdebug.ini
	cp .env.example .env
	cp docker/php-fpm/php-fpm/www.conf.example docker/php-fpm/php-fpm/www.conf
	cp project/.env.dev project/.env
	make d-start
	make composer-install
.PHONY: install-dev

fpm-ssh: ## Connect to containers via SSH
	docker-compose exec -it php-fpm /bin/sh
.PHONY: fpm-ssh

d-start: ## Start application
	docker-compose up -d --build
.PHONY: d-start

d-stop: ## Stop application
	docker-compose down
.PHONY: d-stop

DOCKER-APP-EXEC = docker-compose exec -it php-fpm /bin/sh -c
composer-install: ## Install composer dependencies
	$(DOCKER-APP-EXEC) 'composer install'
.PHONY: composer-install
