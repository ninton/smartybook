# AI Agent Guidelines

このリポジトリは『Smarty動的Webサイト構築入門』のサンプルコードを、PHP 8.5 / Smarty 5 / CI運用環境へモダン化・リファクタリングするプロジェクトです。

---

## 1. 開発方針・変更原則 (Core Principles)

- **マイクロコミット/マイクロPRの徹底**
  - 変更は可能な限り小さく（原則 5〜30 行程度）保ち、1つの関心事（Issue/Task）ごとに分離する。
- **既存の挙動（ゴールデンマスター）の維持**
  - リファクタリング時は表示結果や既存ロジックの挙動を破壊しない。
  - テスト（PHPUnit / Golden Master Test）および静的解析（PHPStan）がパスすることを確認する。
- **段階的な型導入**
  - PHPDoc 情報を優先して native type hinting（引数・戻り値の型宣言）へ昇格させる。

---

## 2. ブランチ運用

- AI は `main` ブランチに直接コミットしてはいけない
- ユーザーが「コミットしてください」とだけ依頼した場合でも、現在ブランチが `main` なら必ず新規作業ブランチを作成してからコミットする
- 直接 `main` にコミットしてよいのは、ユーザーが明示的に「main に直接コミットしてください」と指示した場合のみとする
- 作業ブランチは原則として最新の `main` から作成する
- push / PR 作成の依頼がある場合は、作業ブランチを push して PR を作成する

---

## 3. コミットメッセージ規則

- コミットメッセージは英語で記述する
- Conventional Commits を使用する
  - `feat`, `fix`, `build`, `ci`, `refactor`, `perf`, `test`, `docs`, `style`, `chore`, `revert`
- 破壊的変更は `!` と `BREAKING CHANGE` を使用する
- Subject の動詞は必要に応じて次を優先する
  - `improve`, `change`, `update`, `upgrade`, `remove`, `delete`, `cleanup`, `move`, `rename`
