EXEC=./docker/scripts/exec.sh

.DEFAULT_GOAL := help
.PHONY: help

help:
		@grep -E '(^[0-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-25s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##---------------------------------------------------------------------------
## Docker
##---------------------------------------------------------------------------

init: build up install assets## Init project

build: ## Build all containers
	$(EXEC) build

up: ## Deploy the stack
	$(EXEC) deploy
	$(EXEC) info

down: ## Stop the stack
	$(EXEC) stop

info: ## Display container ID
	$(EXEC) info

exec: ## Go to the PHP container
	$(EXEC) exec

##---------------------------------------------------------------------------
## Symfony commands
##---------------------------------------------------------------------------

install: ## Install dependencies
	$(EXEC) install

update: ## Update dependencies
	$(EXEC) update

clear: ## Clear the cache
	$(EXEC) cache_clear

fixture: ## Generate fixtures
	$(EXEC) fixtures

token: ## Generate JWT token
	$(EXEC) token

test: ## Run the tests
	$(EXEC) tests

tu: ## Run the units tests
	$(EXEC) tu

tf: ## Run the functional tests
	$(EXEC) tf

tu-coverage: ## Run the units tests coverage
	$(EXEC) tu_coverage

tf-coverage: ## Run the units tests coverage
	$(EXEC) tf_coverage

database: ## Create the database
	$(EXEC) database

##---------------------------------------------------------------------------
## Audit
##---------------------------------------------------------------------------

phpcpd: ## Run PHPCPD
	$(EXEC) phpcpd

phpmd: ## Run PHPMD
	$(EXEC) phpmd

phpcs-fixer: ## Run PHPCSFIXER
	$(EXEC) php_cs_fixer

phpcs-fixer-apply: ## Apply PHPCSFIXER
	$(EXEC) php_cs_fixer_apply

##---------------------------------------------------------------------------
## Assets
##---------------------------------------------------------------------------

assets: ## RUN All assets
	$(EXEC) assets

yarn: ## RUN Yarn
	$(EXEC) yarn

watch: ## RUN Yarn in watch mode
	$(EXEC) yarn_watch

ci: ## RUN CI
	$(EXEC) ci
