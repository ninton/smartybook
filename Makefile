.PHONY: composer-install
composer-install:
	docker compose run --rm app composer install

.PHONY: composer-require-checker
composer-require-checker:
	docker compose run --rm app composer run-script composer-require-checker

.PHONY: php-format-check
php-format-check:
	docker compose run --rm app composer run-script format:check

.PHONY: php-format-fix
php-format-fix:
	docker compose run --rm app composer run-script format:fix

.PHONY: php-lint
php-lint:
	docker compose run --rm app composer run-script lint

.PHONY: php-lint-baseline
php-lint-baseline:
# @note phpstan-baseline.neon は手作業で編集することがあるので、自分の権限でファイル作成します
	docker compose run --rm -u $$(id -u):$$(id -g) app composer run-script lint:baseline

.PHONY: php-lint-fix
php-lint-fix:
	docker compose run --rm app composer run-script lint:fix

.PHONY: php-lint-fresh
php-lint-fresh:
	docker compose run --rm app composer run-script lint:fresh

.PHONY: php-test
php-test:
	docker compose run --rm app composer run-script test

.PHONY: php-test-golden-master
php-test-golden-master:
	docker compose up -d
	docker compose exec app composer run-script test:golden-master

.PHONY: php-test-golden-master-update
php-test-golden-master-update:
	docker compose up -d
	docker compose exec app composer run-script test:golden-master-update

# 📁 setup用の状態管理ファイルの保存先ディレクトリ
STATE_DIR := .make

# git clone 直後や日常の git pull後に実行してください
.PHONY: setup
setup: .env $(STATE_DIR)/.docker-compose-build $(STATE_DIR)/.composer-installed
	@printf '\n=== Docker コンテナの起動確認 ===\n'
	docker compose up -d

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

# Composer のインストール
$(STATE_DIR)/.composer-installed: composer.json composer.lock $(STATE_DIR)/.docker-compose-build | $(STATE_DIR)
	@printf '\n=== Composer パッケージの同期 ===\n'
	$(MAKE) composer-install
	@touch $@
