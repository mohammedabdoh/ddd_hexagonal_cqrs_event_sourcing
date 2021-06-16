.PHONY: bootstrap run runpi provision seed test install remove down destroy cache-clear shell-web shell-php shell-mysql shell-redis log-web log-php

bootstrap: ## builds the docker images and starts the application
	@docker-compose up --build -d

run: ## start the containers
	@docker-compose up -d

runpi: ## run the application on a rasperrypi cluster with armhf architecture
	@docker-compose -f docker-compose-rasperrypi.yml up --build -d

provision: ## install dependencies
	@docker run --rm -it -v ${PWD}:/app composer:2.0 instal --ignore-platform-reqs

seed: ## seed the databases
	@docker exec -it php_fpm_container ./bin/console doctrine:schema:create
	@curl -X PUT http://localhost:9200/posts
	@curl -X PUT http://localhost:9200/forums

test: ## run tests
	@docker exec -it php_fpm_container ./vendor/phpunit/phpunit/phpunit

install: ## install php dependency. EX: make install DEP=<package> DEV=--dev
	@docker run --rm -it -v ${PWD}:/app composer:2.0 require $(DEP) $(DEV) --ignore-platform-reqs

remove: ## remove php dependency. EX: make remove DEP=<package> DEV=--dev
	@docker run --rm -it -v ${PWD}:/app composer:2.0 remove $(DEP) $(DEV) --ignore-platform-reqs

down: ## brings down the containers keeping the orphans and volumes
	@docker-compose down || true
	@rm -rf vendor || true
	@rm -rf var || true

destroy: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans --volume || true
	@rm -rf vendor || true
	@rm -rf var || true

cache-clear: ## clear the cache
	@docker exec -it php_fpm_container ./bin/console cache:clear

shell-web: ## shell into the web container
	@docker exec -it web_container sh

shell-php: ## shell into the php container
	@docker exec -it php_fpm_container sh

shell-mysql: ## run the mysql client on the database container
	@docker exec -it db_container mysql -u root -p

shell-redis: ## run the redis client on the redis container
	@docker exec -it redis_container redis-cli

log-web: ## logs the web container
	@docker logs -f web_container

log-php: ## logs the php container
	@docker logs -f php_fpm_container

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
