#!/usr/bin/env bash
set -e
set -u
set -x

# --- 実行位置の補正 ---
# スクリプト自身の場所（scripts/local）から、2階層上のプロジェクトルートへ移動
cd "$(dirname "$0")/../.."

# --- .envファイルに置き換えたい ---
DB_HOST=db
DB_ROOT_PASSWORD=password
DB_DATABASE=smartybook

# --- 設定 ---
INIT_SQL_DIR="./docker/db/init"

sql_file="${INIT_SQL_DIR}/db_init.sql"

# app コンテナ内から mysql クライアントで db コンテナへ接続し、SQL を流し込む
# MySQL 8.0〜 --ssl-mode=DISABLED
# 〜MySQL 5.7 --skip-ssl
MYSQL_PWD="${DB_ROOT_PASSWORD:-password}" mysql --skip-ssl \
    --default-character-set=utf8mb4 \
    --host="${DB_HOST:?DB_HOST is required}" \
    --user=root \
    "${DB_DATABASE:?DB_DATABASE is required}" <"${sql_file}"
