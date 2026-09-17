#!/usr/bin/env bash
set -e
set -u
set -x

# --- 実行位置の補正 ---
# スクリプト自身の場所（scripts/local）から、2階層上のプロジェクトルートへ移動
cd "$(dirname "$0")/../.."

# --- .envファイルに置き換えたい ---
DB_HOST=db
DB_PORT=3306
DB_USER=root

# --- 設定 ---
INIT_SQL_DIR="./docker/db/init"

sql_file="${INIT_SQL_DIR}/db_init.sql"

mysql --default-character-set=utf8 --user=$DB_USER --port=$DB_PORT --host=$DB_HOST <"${sql_file}"
