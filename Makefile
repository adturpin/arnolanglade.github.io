DOCKER_COMPOSE=docker-compose

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

composer.lock: composer.json
	$(DOCKER_COMPOSE) run --rm composer /usr/local/bin/composer update

vendor: composer.lock
	$(DOCKER_COMPOSE) run --rm composer /usr/local/bin/composer install

.PHONY: blog
blog: vendor
	$(DOCKER_COMPOSE) run --rm php blog/bin/make.php
