# GridBundle

[![PHPStan](https://github.com/TheoVauvilliers/GridBundle/actions/workflows/phpstan.yml/badge.svg?branch=main)](https://github.com/TheoVauvilliers/GridBundle/actions/workflows/phpstan.yml)
[![PHPUnit](https://github.com/TheoVauvilliers/GridBundle/actions/workflows/phpunit.yml/badge.svg?branch=main)](https://github.com/TheoVauvilliers/GridBundle/actions/workflows/phpunit.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/theovauvilliers/grid-bundle.svg)](https://packagist.org/packages/theovauvilliers/grid-bundle)

Minimal setup to work on the bundle locally using Docker. No local PHP/Composer required.

## Requirements

- Docker with Docker Compose v2

> Commands below assume services named `php` and `composer`.

## Install
```bash
git clone https://github.com/TheoVauvilliers/GridBundle.git
cd GridBundle
docker compose run --rm composer install
```

## Run tools

### PHPUnit
```bash
docker compose run --rm php vendor/bin/phpunit -c phpunit.xml.dist --colors=always
```

### PHPStan
```bash
docker compose run --rm php vendor/bin/phpstan analyse -c phpstan.neon --no-progress --ansi
```

### php-cs-fixer
```bash
# check (no changes)
docker compose run --rm php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --dry-run --diff --ansi
# fix in place
docker compose run --rm php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --ansi
```

### Composer
```bash
docker compose run --rm composer update
```

### Tips

- Cache: add `-v $(pwd)/.cache:/tmp/cache` to persist tool caches between runs.
- If your service names differ, replace `php`/`composer` accordingly.

## Releases

We release by **fast-forwarding `main` from `develop`**.  
Maintainers: see **[RELEASE.md](./RELEASE.md)** for the exact commands and branch protection settings.

