# 速習Webテクニック Smarty 動的Webサイト構築入門　掲載コードリポジトリ

## このリポジトリについて

2008年出版の『Smarty動的Webサイト構築入門』のサンプルコードを、PHP 8.x + Smarty 5 環境で動作するようにメンテナンスしたものです。

- 2008年当時の設計（フレームワークレスな構造）や Smarty の学習目的を損なわないよう配慮しています。
- メンテナンスが終了した PEAR パッケージや廃止された外部API（Amazon ECS）は、最小限のスタブ（Stub）クラスに置き換えています。

レガシーな PHP/Smarty プロジェクトを現代の PHP 環境へ安全に移行・リファクタリングする際の実践的な参考になれば幸いです。

『Smarty動的Webサイト構築入門』
- https://gihyo.jp/book/2008/978-4-7741-3630-1
- https://www.amazon.co.jp/dp/4774136301

## ReadMe.txt

CD-ROM収録時の ReadMe.txt
```
_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/

速習Webテクニック Smarty 動的Webサイト構築入門　付属CD-ROM

(C)2008　原一浩、青木真、川野辺亮、鵜飼孝陽、（株）技術評論社

_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/


■免責
　本書および本CD-ROM利用の結果、万が一障害などが発生しても、弊社およ
び著者、書籍制作に関わったすべての関係者は、一切の責任を負いません。
必ずご自身の責任においてご利用ください。


■本CD-ROMの収録内容について

・ReadMe.txt　-　このファイルです

・［smartybook］フォルダ　-　本書使用するファイルその他が収録されてい
　ます。必要に応じてハードディスクにコピーしてお使いください。
　詳しくは本書5ページをご覧ください。
　なお、本書掲載のサンプルとは違い、著作権の観点から、本CD-ROMに収録で
　きない写真は差し替えております。ご了承ください。
```

## 正誤表

https://github.com/ninton/smartybook/wiki/%E6%AD%A3%E8%AA%A4%E8%A1%A8

## 概要

- **言語・フレームワーク:** PHP 8.5 / Smarty 5
- **インフラ:** ローカル開発環境のみ
- **デプロイ:** なし

## ディレクトリ構成

```
.
├── bin
├── docker
│   ├── app
│   │   └── Dockerfile
│   └── db
│       └── init
│           └── db_init.sql
├── scripts
│   └── local
├── smartybook
│   ├── chapter2
│   ├── chapter3
│   ├── chapter4_1
│   ├── chapter4_2_1
│   ├── chapter4_2_2
│   ├── chapter4_2_3
│   ├── chapter4_2_4
│   ├── chapter4_3_1
│   ├── chapter4_3_2
│   ├── chapter4_3_3
│   ├── chapter4_4
│   ├── chapter4_5
│   ├── chapter4_6
│   ├── chapter4_7
│   ├── chapter4_8
│   ├── chapter4_9
│   ├── chapter5_1
│   ├── chapter5_2
│   ├── chapter5_3
│   ├── chapter5_4
│   ├── chapter5_5
│   └── chapter5_6
├── tests
│   └── GoldenMaster
├── vendor
├── .env.sample
├── composer.json
├── docker-compose.yml
└── Makefile
```

## 開発環境のセットアップ

### 必要なもの

- Docker / Docker Compose
- GNU Make

### 手順

#### クイックスタート（Docker）

```bash
# 1. リポジトリをクローン
git clone git@github.com:ninton/smartybook.git
cd smartybook

# 2. 環境セットアップ
make setup
```

#### 更新（git pull 後に実行）

```bash
# タイムスタンプを見て必要な処理（docker compose build / composer install）だけ実行します。
git pull
make setup
```

起動後、以下の URL でアクセスできます。

- アプリ: `http://127.0.0.1:<APP_PORT>`（例: `http://127.0.0.1:3000`）にアクセスしてください。ポート番号は .env の APP_PORT で変更可能です。
  - phpinfo: 例: `http://127.0.0.1:3000/smartybook/chapter2/phpinfo.php`
  - chapter3/03_01.php: 例: `http://127.0.0.1:3000/smartybook/chapter3/03_01.php`
- phpMyAdmin: `http://127.0.0.1:<PMA_PORT>`（例: `http://127.0.0.1:3001`）にアクセスしてください。ポート番号は .env の PMA_PORT で変更可能です。

## よく使うコマンド

```bash
make composer-install          # composer install

make php-lint                  # PHPStan 静的解析
make php-lint-fix              # PHPStan 自動修正
make php-lint-baseline         # PHPStan ベースライン更新

make php-format-check          # php-cs-fixer コードスタイルチェック
make php-format-fix            # php-cs-fixer コードスタイル更新

make php-test                  # PHPUnit Unit テスト実行
make php-test-golden-master    # ゴールデンマスターテスト実行

make php-test-golden-master-update # ゴールデンマスターテストの期待値を更新する
```
