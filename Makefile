.PHONY: composer-install
composer-install:
	docker compose run --rm php-web composer install

.PHONY: composer-require-checker
composer-require-checker:
	docker compose run --rm php-web composer run-script composer-require-checker

.PHONY: php-format-check
php-format-check:
	docker compose run --rm php-web composer run-script format:check

.PHONY: php-format-fix
php-format-fix:
	docker compose run --rm php-web composer run-script format:fix

.PHONY: php-lint
php-lint:
	docker compose run --rm php-web composer run-script lint

.PHONY: php-lint-baseline
php-lint-baseline:
	docker compose run --rm php-web composer run-script lint:baseline

.PHONY: php-lint-fix
php-lint-fix:
	docker compose run --rm php-web composer run-script lint:fix

.PHONY: php-lint-fresh
php-lint-fresh:
	docker compose run --rm php-web composer run-script lint:fresh

.PHONY: php-test
php-test:
	docker compose run --rm php-web composer run-script test

.PHONY: php-test-golden-master
php-test-golden-master:
	docker compose up -d
	docker compose exec php-web composer run-script test:golden-master

.PHONY: php-test-golden-master-update
php-test-golden-master-update:
	docker compose up -d
	docker compose exec php-web composer run-script test:golden-master-update

.PHONY: smarty-lint
smarty-lint:
	docker compose run --rm php-web composer run-script smarty-lint templates

# 📁 setup用の状態管理ファイルの保存先ディレクトリ
STATE_DIR := .make

# MariaDB の初期投入SQL
DB_INIT_FILE := docker/mariadb-db/init/db_init.sql

# git clone 直後や日常の git pull後に実行してください
# @note GitHub Actions ワークフロー (.github/workflows/feature.yml) のセットアップ手順と同期してください。
# CI環境では docker compose build の代わりに docker/bake-action を利用してレイヤーキャッシュを適用しています。
.PHONY: setup
setup: .env $(STATE_DIR)/.docker-compose-build $(STATE_DIR)/.composer-installed $(STATE_DIR)/.pnpm-installed $(STATE_DIR)/.db-init-hash
	@printf '\n=== Docker コンテナの起動確認 ===\n'
	docker compose up -d --remove-orphans
	docker compose run --rm php-web bash scripts/chmod.sh

	@printf '\n🎉 セットアップが完了しました！\n'

# ディレクトリが存在しない場合は自動で作成する
$(STATE_DIR):
	@mkdir -p $(STATE_DIR)

.env: .env.example
	@echo "=== .env の差分チェック ==="
	@if [ ! -f .env ]; then \
		cp .env.example .env && \
		echo "Created .env from .env.example"; \
	else \
		MISSING=$$(grep -v '^#' .env.example | grep '=' | cut -d'=' -f1 | while read -r key; do \
			if ! grep -q "^$${key}=" .env; then \
				echo "  - $${key}"; \
			fi; \
		done); \
		if [ -n "$${MISSING}" ]; then \
			echo "⚠️  .env.example に新しい変数が追加されています。"; \
			printf '以下の変数を .env に追加してください:\n\n'; \
			printf '%s\n\n' "$${MISSING}"; \
		else \
			echo "✅ .env は最新です。"; \
		fi; \
	fi

# Docker  コンテナのビルド（$(STATE_DIR) ディレクトリ自体の存在も依存関係に加える）
DOCKER_FILES := $(shell find docker -type f)
$(STATE_DIR)/.docker-compose-build: docker-compose.yml $(DOCKER_FILES) | $(STATE_DIR)
	@printf '\n=== Docker コンテナのビルド ===\n'
	docker compose build --pull
	@touch $@

# Composer のインストール（Composer はDocker経由で実行します）
$(STATE_DIR)/.composer-installed: composer.json composer.lock $(STATE_DIR)/.docker-compose-build | $(STATE_DIR)
	@printf '\n=== Composer パッケージの同期 ===\n'
	$(MAKE) composer-install
	@touch $@

# pnpm のインストール（pnpm はホストOSで実行します）
$(STATE_DIR)/.pnpm-installed: package.json pnpm-lock.yaml | $(STATE_DIR)
	@printf '\n=== pnpm パッケージの同期 ===\n'
	pnpm install --frozen-lockfile
	@touch $@

# db_init.sql の変更検知と注意喚起（Make本来のタイムスタンプ/依存関係を活用）
$(STATE_DIR)/.db-init-hash: $(DB_INIT_FILE) | $(STATE_DIR)
	@if [ -f $@ ]; then \
		printf '\n\033[33m⚠️  [注意] db_init.sql が更新されています。\033[0m\n'; \
		printf 'データベース構造や初期データを再反映するには、一度以下を実行してください:\n'; \
		printf '  \033[1mdocker compose down -v && make setup\033[0m\n\n'; \
	fi
	@sha256sum $(DB_INIT_FILE) | cut -d' ' -f1 > $@
