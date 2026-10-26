# 速習Webテクニック Smarty 動的Webサイト構築入門　掲載コードリポジトリ

## このリポジトリについて

2008年出版の『Smarty動的Webサイト構築入門』のサンプルコードを、PHP 8.x + Smarty 5 環境で動作するようにメンテナンスしたものです。

- 2008年当時の設計（フレームワークレスな構造）や Smarty の学習目的を損なわないよう配慮しています。
- メンテナンスが終了した PEAR パッケージや廃止された外部API（Amazon ECS）は、最小限のスタブ（Stub）クラスに置き換えています。

レガシーな PHP/Smarty プロジェクトを現代の PHP 環境へ安全に移行・リファクタリングする際の実践的な参考になれば幸いです。

『Smarty動的Webサイト構築入門』

- https://gihyo.jp/book/2008/978-4-7741-3630-1
- https://www.amazon.co.jp/dp/4774136301

## Smarty

- GitHub https://github.com/smarty-php/smarty
- Documentation https://smarty-php.github.io/smarty/
- Packagist https://packagist.org/packages/smarty/smarty

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
├── app                       共通で使うPHPクラス
│   └── PearStub             PEARライブラリのスタブクラス
├── docker
│   ├── app
│   │   └── Dockerfile
│   └── db
│       └── init
│           └── db_init.sql
├── cache                       Smarty用キャッシュディレクトリ
├── scripts
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
├── templates                        Smarty用テンプレートディレクトリ
├── templates_c                      Smarty用コンパイルディレクトリ
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

make php-test                  # Pest Unit テスト実行
make php-test-golden-master    # ゴールデンマスターテスト実行

make php-test-golden-master-update # ゴールデンマスターテストの期待値を更新する
```

## Wiki

- [メンテナンスでの変更点](https://github.com/ninton/smartybook/wiki/%E3%83%A1%E3%83%B3%E3%83%86%E3%83%8A%E3%83%B3%E3%82%B9%E3%81%A7%E3%81%AE%E5%A4%89%E6%9B%B4%E7%82%B9)

- [レガシーPHPリファクタ 1：「ロジックとHTMLの分離配置」でコードの見通しを激変させる](https://github.com/ninton/smartybook/wiki/%E3%83%AC%E3%82%AC%E3%82%B7%E3%83%BCPHP%E3%83%AA%E3%83%95%E3%82%A1%E3%82%AF%E3%82%BF-1%EF%BC%9A%E3%80%8C%E3%83%AD%E3%82%B8%E3%83%83%E3%82%AF%E3%81%A8HTML%E3%81%AE%E5%88%86%E9%9B%A2%E9%85%8D%E7%BD%AE%E3%80%8D%E3%81%A7%E3%82%B3%E3%83%BC%E3%83%89%E3%81%AE%E8%A6%8B%E9%80%9A%E3%81%97%E3%82%92%E6%BF%80%E5%A4%89%E3%81%95%E3%81%9B%E3%82%8B)
- [レガシーPHPリファクタ 2：「たかが変数名」とバカにできない！安全にコードの可読性とAI精度を引き上げるリネーム戦略](https://github.com/ninton/smartybook/wiki/%E3%83%AC%E3%82%AC%E3%82%B7%E3%83%BCPHP%E3%83%AA%E3%83%95%E3%82%A1%E3%82%AF%E3%82%BF-2%EF%BC%9A%E3%80%8C%E3%81%9F%E3%81%8B%E3%81%8C%E5%A4%89%E6%95%B0%E5%90%8D%E3%80%8D%E3%81%A8%E3%83%90%E3%82%AB%E3%81%AB%E3%81%A7%E3%81%8D%E3%81%AA%E3%81%84%EF%BC%81%E5%AE%89%E5%85%A8%E3%81%AB%E3%82%B3%E3%83%BC%E3%83%89%E3%81%AE%E5%8F%AF%E8%AA%AD%E6%80%A7%E3%81%A8AI%E7%B2%BE%E5%BA%A6%E3%82%92%E5%BC%95%E3%81%8D%E4%B8%8A%E3%81%92%E3%82%8B%E3%83%AA%E3%83%8D%E3%83%BC%E3%83%A0%E6%88%A6%E7%95%A5)
- [レガシーPHPリファクタ 3：`for` ループを `foreach` 代替構文に置き換えて可読性と安全性UP](https://github.com/ninton/smartybook/wiki/%E3%83%AC%E3%82%AC%E3%82%B7%E3%83%BCPHP%E3%83%AA%E3%83%95%E3%82%A1%E3%82%AF%E3%82%BF-3%EF%BC%9A%60for%60-%E3%83%AB%E3%83%BC%E3%83%97%E3%82%92-%60foreach%60-%E4%BB%A3%E6%9B%BF%E6%A7%8B%E6%96%87%E3%81%AB%E7%BD%AE%E3%81%8D%E6%8F%9B%E3%81%88%E3%81%A6%E5%8F%AF%E8%AA%AD%E6%80%A7%E3%81%A8%E5%AE%89%E5%85%A8%E6%80%A7UP)
- [レガシーPHPリファクタ 4：「暗黙の0」を排して意図を明示化する](https://github.com/ninton/smartybook/wiki/%E3%83%AC%E3%82%AC%E3%82%B7%E3%83%BCPHP%E3%83%AA%E3%83%95%E3%82%A1%E3%82%AF%E3%82%BF-4%EF%BC%9A%E3%80%8C%E6%9A%97%E9%BB%99%E3%81%AE0%E3%80%8D%E3%82%92%E6%8E%92%E3%81%97%E3%81%A6%E6%84%8F%E5%9B%B3%E3%82%92%E6%98%8E%E7%A4%BA%E5%8C%96%E3%81%99%E3%82%8B)
