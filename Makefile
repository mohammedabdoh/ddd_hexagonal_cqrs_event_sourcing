.PHONY: run test api-docs clean help

run: ## run the application
	@docker-compose up --build -d
	@docker exec -it billie_composer_container composer install
	@docker exec -it billie_php_fpm_container ./bin/console cache:warmup
	@docker stop billie_composer_container && docker rm billie_composer_container
	@printf "\n-> Service is available at: http://localhost"
	@printf "\n-> Example: http://localhost/mars-time/convert/2020-07-11T16:36:52+00:00\n"

test: ## run unit and functional tests
	@docker exec -it billie_php_fpm_container ./vendor/phpunit/phpunit/phpunit

api-docs: ## open the api docs
	@open http://localhost/docs/

clean: ## stops the containers if exists and remove all the dependencies
	@docker-compose down --remove-orphans || true
	@rm -rf vendor || true
	@rm -rf var || true
	@rm -rf composer.lock || true
	
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help
