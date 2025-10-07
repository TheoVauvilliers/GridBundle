# GridBundle

This repository ships with a lightweight Docker setup to run all dev tools (Composer, PHPUnit, PHPStan, PHPCS, CS Fixer) without installing PHP or Composer locally.

The Makefile wraps docker `compose run` so you can run one-off commands in ephemeral containers.

## Prerequisites

- **Docker + Docker Compose v2** (`docker compose ...`)
- **make** available on your machine
  - macOS/Linux: already available or `brew install make`
  - Windows: install via **Chocolatey** (`choco install make`) or **Scoop** (`scoop install make`)  
    *No make? See “Windows without make” below.*

You do not need to run `docker compose up -d`. We only run short-lived CLI containers.

## Quickstart

```bash
# From the repository root
make install   # composer install inside a container
make test      # run PHPUnit
make stan      # run PHPStan
make cs        # run PHP_CodeSniffer
make cs-fix    # run PHP CS Fixer (if present)
make qa        # run static analysis + code style check
```

## Available targets

| Target                     | What it does                                   |
| -------------------------- |------------------------------------------------|
| `make install`             | `composer install --no-interaction`            |
| `make update`              | `composer update --no-interaction`             |
| `make dump-autoload`       | `composer dump-autoload -o`                    |
| `make composer ARGS="..."` | Run any Composer command (see examples below)  |
| `make test`                | `vendor/bin/phpunit`                           |
| `make stan`                | `vendor/bin/phpstan analyse`                   |
| `make cs`                  | `vendor/bin/php-cs-fixer check --diff`         |
| `make cs-fix`              | `vendor/bin/php-cs-fixer fix --using-cache=no` |
| `make qa`                  | Shortcut for `stan` + `cs`                     |
| `make help`                | Print a short help text                        |

### Composer passthrough examples

```bash
make composer ARGS="require symfony/console:^7.0"
make composer ARGS="remove vendor/package"
make composer ARGS="show -D"
```

## How it works

The Makefile calls:

- `docker compose run --rm composer ...` for **Composer** tasks
- `docker compose run --rm php ...` for **PHP** tools (phpunit, phpstan, phpcs, cs-fixer)

This spins up a throwaway container, executes the command, then removes it. Your project directory is mounted at `/app`, so changes (e.g., `vendor/`) persist on your host.

### Windows without make (PowerShell)

If you don’t want to install make, run the underlying commands directly:

```bash
docker compose run --rm composer install
docker compose run --rm php vendor/bin/phpunit
docker compose run --rm php vendor/bin/phpstan analyse
docker compose run --rm php vendor/bin/php-cs-fixer check --diff
docker compose run --rm php vendor/bin/php-cs-fixer fix --using-cache=no
```

Optionally, add a small PowerShell wrapper script if you prefer aliases.

## Tips & troubleshooting

- **No need for** `up -d`: these are one-off CLI tasks. Use `up -d` only if you later add long-running services (DB, Redis, etc.).
- **First run fails with missing** `vendor/` → run `make install`.
- **File ownership issues (WSL/Linux)**: run with your user ID:
  ```bash
  make install UID=$(id -u) GID=$(id -g)
  ```
  (The Makefile honors `UID`/`GID` and forwards them to `docker compose run`.)
- **Extensions needed** (intl/zip, etc.): add a `Dockerfile` for the `php` service and `docker compose build`.
- **Composer cache**: the compose file mounts a cache volume to speed up installs.
