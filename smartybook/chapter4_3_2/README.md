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

> **Note (`{fetch}` タグの仕様について)**
> Smarty 5 でも `{fetch}` タグは使用可能ですが、セキュリティ設定（`Smarty_Security`）が有効な環境では制限を受ける場合があります。また、パフォーマンスやMVC分離の観点から、実務では PHP 側でデータを取得してアサインするか、テンプレート分割（`{include}`）を用いるのが一般的です。
