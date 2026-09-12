# 速習Webテクニック Smarty 動的Webサイト構築入門　掲載コードリポジトリ

## ReadMe.txt

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

## Wiki

https://github.com/ninton/smartybook/wiki


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

- アプリ: `http://127.0.0.1:5402`（例: `http://127.0.0.1:5402`）にアクセスしてください。ポート番号は 5402 固定です。
- 例: phpinfo `http://127.0.0.1:5402/smartybook/chapter2/phpinfo.php`
