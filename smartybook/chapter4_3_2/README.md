# 4.3.2章 {fetch} タグのサンプル

## ディレクトリ構成と役割

```text
chapter4_3_2/
├── index.php           # 実行スクリプト
└── data/
    └── notice.txt      # {fetch} で読み込むテキストファイル（Smartyテンプレートではありません）

```

※ `index.tpl` は共通テンプレートディレクトリ（`templates/pages/chapter4_3_2/index.tpl`）に配置されています。

## `{fetch}` タグのポイント

* **Smartyテンプレート外のファイル取得**
`data/notice.txt` は Smarty テンプレート（`.tpl`）ではなく、普通のテキストファイルです。
PHPスクリプト（`index.php`）側で読み込まずに、テンプレート内の `{fetch file="data/notice.txt"}` から直接読み込んで表示しています。
* **パスの基準位置**
`{fetch}` の `file` 属性に指定するパスは、Smarty の `template_dir` ではなく、**実行している PHP スクリプト（`index.php`）からの相対パス** になります。

> **Note (Smartyの仕様について)**
> `{fetch}` は便利な反面、ローカルの任意のファイルを読み込めてしまうため、近年の Smarty（Smarty 4 / 5 以降）ではセキュリティ上の理由により非推奨または削除されています。実務で同様の処理を行う場合は、PHP側でファイルを読み込んで変数にアサインするか、Smarty テンプレートとして分割して `{include}` を使用することが推奨されます。
