#!/usr/bin/env bash

set -e

# --- 実行位置の補正 ---
# スクリプト自身の場所（scripts/local）から、2階層上のプロジェクトルートへ移動
cd "$(dirname "$0")/../.."

# --- .env ファイルの読み込み ---
if [ -f .env ]; then
  # 自動エクスポートを有効化
  set -a
  # .env を現在のシェルに読み込む（shellcheckの別警告対策で一応 source ではなく . を使用）
  # shellcheck source=/dev/null
  . .env
  # 自動エクスポートを無効化（元に戻す）
  set +a
else
  echo ".env ファイルが見つかりません。環境変数（DB_HOST / DB_DATABASE / DB_ROOT_PASSWORD など）が設定済みであれば続行します。"
fi

# --- 設定 ---
MYSQL_ROOT_PASSWORD="${DB_ROOT_PASSWORD:?DB_ROOT_PASSWORD is required}"
# プロジェクトルートからの相対パスなので、この指定で固定できます
INIT_SQL_DIR="./docker/db/init"

# --- 設定 ---
INIT_SQL_DIR="./docker/db/init"

echo "🔄 データベースの初期化を開始します..."

sql_file="${INIT_SQL_DIR}/db_init.sql"

# app コンテナ内から mysql クライアントで db コンテナへ接続し、SQL を流し込む
# MySQL 8.0〜 --ssl-mode=DISABLED
# 〜MySQL 5.7 --skip-ssl
MYSQL_PWD="${MYSQL_ROOT_PASSWORD}" mysql --skip-ssl \
    --default-character-set=utf8mb4 \
    --host="${DB_HOST:?DB_HOST is required}" \
    --user=root \
    <"${sql_file}"

echo "✨ SQL ファイルの実行が完了しました！"
