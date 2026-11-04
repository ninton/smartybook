#!/usr/bin/env bash

set -e

# --- 実行位置の補正 ---
# スクリプト自身の場所（scripts）から、1階層上のプロジェクトルートへ移動
cd "$(dirname "$0")/.."

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
INIT_SQL_DIR="./docker/mariadb-db/init"

# CI 環境では MySQL サーバーが起動するまで待機する必要がある場合がある
echo "🔄 MySQLサーバーの起動を待っています..."

# MySQLへの接続を最大60回試行する
for attempt in {1..60}; do
  if MYSQL_PWD="${MYSQL_ROOT_PASSWORD}" mysql --skip-ssl \
    -h "${DB_HOST:?DB_HOST is required}" -uroot \
    -e 'SELECT 1' > /dev/null 2>&1; then
    break
  fi
  if [ "${attempt}" -eq 60 ]; then
    echo "MySQLへの接続待機がタイムアウトしました。" >&2
    exit 1
  fi
  sleep 1
done

echo "🔄 データベースの初期化を開始します..."

sql_file="${INIT_SQL_DIR}/db_init.sql"

# php-web コンテナ内から mysql クライアントで mariadb-db コンテナへ接続し、SQL を流し込む
# MySQL 8.0〜 --ssl-mode=DISABLED
# 〜MySQL 5.7 --skip-ssl
MYSQL_PWD="${MYSQL_ROOT_PASSWORD}" mysql --skip-ssl \
    --default-character-set=utf8mb4 \
    --host="${DB_HOST:?DB_HOST is required}" \
    --user=root \
    <"${sql_file}"

echo "✨ SQL ファイルの実行が完了しました！"
