.PHONY: run provision seed test install remove clean help

run: ## run the application
	@docker-compose up --build -d

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

clean: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans || true
	@rm -rf vendor || true
	@rm -rf var || true

shell-web: ## shell into the web container
	@docker exec -it web_container sh

shell-php: ## shell into the php container
	@docker exec -it php_fpm_container sh

log-web: ## logs the web container
	@docker logs -f web_container

log-php: ## logs the php container
	@docker logs -f php_fpm_container

shell-mysql: ## run the mysql client on the database container
	@docker exec -it db_container mysql -u root -p

shell-redis: ## run the redis client on the redis container
	@docker exec -it redis_container redis-cli

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
