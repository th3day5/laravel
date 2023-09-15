COMPOSE=docker-compose
EXEC=docker-compose run --rm --no-deps --entrypoint '' app
NODE_EXEC=docker-compose run --rm --no-deps --entrypoint '' node

ifeq (npm-install,$(firstword $(MAKECMDGOALS)))
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  $(eval $(RUN_ARGS):;@:)
endif

default: help
run: ## Start all detached containers
	${COMPOSE} up -d --force-recreate
# Scripts
seed: ## Run laravel seeders
	${EXEC} php artisan db:seed
migrate: ## Run laravel migrations
	${EXEC} php artisan migrate
migrate-fresh: ## Run laravel fresh migration
	${EXEC} php artisan migrate:fresh
# Dependencies
help: ## Get this help.
	@echo Tasks:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
install: ## Install project
	${EXEC} composer install
	${EXEC} php artisan key:generate
update:
	${EXEC} composer update
# docker-compose control
stop: ## Stop project
	${COMPOSE} down
logs: ## Show containers logs
	${COMPOSE} logs -f
list: ## Show list of containers
	${COMPOSE} ps
bash: ## Bash to php container
	${EXEC} bash
bash-node: ## Bash to node container
	${NODE_EXEC} sh
npm-install: ## Install node modules or some package (to install package use make npm-install PACKAGE_NAME)
	${NODE_EXEC} npm i --save $(RUN_ARGS)
npm-run-prod: ## Run npm run prod command
	${NODE_EXEC} npm run prod
npm-run-watch: ## Run npm run watch command
	${NODE_EXEC} npm run watch
test: ## Run tests
	${EXEC} php artisan config:clear
	${EXEC} php artisan test
test-coverage: ## Run tests and show code coverage
	${EXEC} php artisan config:clear
	${EXEC} ./vendor/bin/phpunit --coverage-text # after migration to Laravel 9 use php artisan test --coverage
# Reusable scripts
compose:
	echo ${COMPOSE}
exec:
	echo ${EXEC}
