.PHONY: composer-install
composer-install:
	docker compose run --rm app composer install
	docker compose run --rm app bin/patch-pear.sh

# 📁 setup用の状態管理ファイルの保存先ディレクトリ
STATE_DIR := .make

# git clone 直後や日常の git pull後に実行してください
.PHONY: setup
setup: $(STATE_DIR)/.docker-compose-build $(STATE_DIR)/.composer-installed
	@printf '\n=== Docker コンテナの起動確認 ===\n'
	docker compose up -d
	docker compose run --rm app bin/chmod.sh

	@printf '\n🎉 セットアップが完了しました！\n'

# ディレクトリが存在しない場合は自動で作成する
$(STATE_DIR):
	@mkdir -p $(STATE_DIR)

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
