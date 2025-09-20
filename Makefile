build: ## Install project for development
	cp docker/php-fpm/xdebug/xdebug.ini.example docker/php-fpm/xdebug/xdebug.ini
	cp docker/php-fpm/php-fpm/www.conf.example docker/php-fpm/php-fpm/www.conf
	cp project/.env.dev project/.env
	make up
	make composer-install
.PHONY: build

fpm-ssh: ## Connect to containers via SSH
	docker-compose exec -it php-fpm /bin/sh
.PHONY: fpm-ssh

up: ## Start application
	docker-compose up -d --build
.PHONY: up

down: ## Stop application
	docker-compose down
.PHONY: down
