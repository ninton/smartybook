import js from '@eslint/js';
import tseslint from 'typescript-eslint';
import prettierConfig from 'eslint-config-prettier';

export default tseslint.config(
  // 除外対象（.gitignore 相当）
  {
    ignores: ['node_modules/', 'vendor/', 'templates_c/', 'cache/', '*.min.js', 'smartybook/chapter5_1/flash/'],
  },
  // JS & TS 共通推奨ルール
  js.configs.recommended,
  ...tseslint.configs.recommended,
  // Prettier と競合するルールを無効化
  prettierConfig,
  {
    files: ['**/*.{js,mjs,cjs,ts,tsx}'],
    rules: {
      // レガシーコードリファクタリング時に段階的に調整するルール例
      '@typescript-eslint/no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
      'no-console': 'warn',
    },
  },
);
