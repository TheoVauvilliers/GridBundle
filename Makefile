DC            ?= docker compose
PHP_SVC       ?= php
COMPOSER_SVC  ?= composer

RUN_PHP       := $(DC) run --rm $(PHP_SVC)
RUN_COMPOSER  := $(DC) run --rm $(COMPOSER_SVC)

ifdef UID
  RUN_PHP      := $(DC) run --rm --user $(UID):$(GID) $(PHP_SVC)
  RUN_COMPOSER := $(DC) run --rm --user $(UID):$(GID) $(COMPOSER_SVC)
endif

.PHONY: help
help:
	@echo "Cibles disponibles :"
	@echo "  install        - composer install"
	@echo "  update         - composer update"
	@echo "  dump-autoload  - composer dump-autoload -o"
	@echo "  test           - vendor/bin/phpunit"
	@echo "  stan           - vendor/bin/phpstan analyse"
	@echo "  cs             - vendor/bin/phpcs (style check)"
	@echo "  cs-fix         - vendor/bin/php-cs-fixer fix (si présent)"
	@echo "  qa             - enchaîne stan + cs"
	@echo "  composer ARGS= - ex: make composer ARGS='require foo/bar:^1.0'"
	@echo "  clean-cache    - composer clear-cache"

.PHONY: install update dump-autoload composer clean-cache
install:
	$(RUN_COMPOSER) install --no-interaction

update:
	$(RUN_COMPOSER) update --no-interaction

dump-autoload:
	$(RUN_COMPOSER) dump-autoload -o

composer:
	$(RUN_COMPOSER) $(ARGS)

clean-cache:
	$(RUN_COMPOSER) clear-cache

.PHONY: test stan cs cs-fix qa
test:
	$(RUN_PHP) vendor/bin/phpunit

stan:
	$(RUN_PHP) vendor/bin/phpstan analyse

cs:
	$(RUN_PHP) vendor/bin/php-cs-fixer check --diff

cs-fix:
	$(RUN_PHP) vendor/bin/php-cs-fixer fix --using-cache=no

qa: stan cs
