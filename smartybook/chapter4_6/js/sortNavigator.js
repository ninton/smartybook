document.addEventListener('DOMContentLoaded', () => {
  const headerRow = document.getElementById('sortable-header');
  if (!headerRow) return;

  // PHP側で確定したソート状態を利用する
  const currentSort = headerRow.dataset.currentSort || 'id';
  const currentDir = headerRow.dataset.currentDir || 'asc';

  // 2. 現在アクティブなソート項目のアイコンを _current.gif に差し替え
  const thElements = headerRow.querySelectorAll('th[data-sort-key]');
  thElements.forEach((th) => {
    const sortKey = /** @type {HTMLElement} */ (th).dataset.sortKey;
    // noinspection JSIncompatibleTypesComparison PhpStormの誤検知
    if (sortKey === currentSort) {
      const targetLink = Array.from(th.querySelectorAll('a[data-direction]'))
        .find((link) => /** @type {HTMLElement} */ (link).dataset.direction === currentDir)
        ?.querySelector('img');
      if (targetLink) {
        targetLink.src = targetLink.src.replace('.gif', '_current.gif');
      }
    }
  });

  // ソート先を設定し、ブラウザー標準のリンク操作を維持する
  /** @type {NodeListOf<HTMLAnchorElement>} */
  const links = headerRow.querySelectorAll('th[data-sort-key] a[data-direction]');
  links.forEach((link) => {
    const th = link.closest('th');
    if (!th) return;

    const sortKey = th.dataset.sortKey;
    const direction = link.dataset.direction;
    if (!sortKey || !direction) return; // 必須の属性値が存在しない場合はスキップ

    const params = new URLSearchParams(window.location.search);
    params.set('sort_key', sortKey);
    params.set('sort_direction', direction);
    params.set('pageID', '1'); // ソート変更時は1ページ目に戻す
    const scriptName = headerRow.dataset.scriptName || window.location.pathname;
    link.href = `${scriptName}?${params.toString()}`;
  });
});
