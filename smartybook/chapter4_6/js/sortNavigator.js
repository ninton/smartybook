document.addEventListener('DOMContentLoaded', () => {
  const headerRow = document.getElementById('sortable-header');
  if (!headerRow) return;

  // PHP側で確定したソート状態を利用する
  const currentSort = headerRow.dataset.currentSort || 'id';
  const currentDir = headerRow.dataset.currentDir || 'asc';

  // 2. 現在アクティブなソート項目のアイコンを _current.gif に差し替え
  const thElements = headerRow.querySelectorAll('th[data-sort-key]');
  thElements.forEach(th => {
    const sortKey = th.dataset.sortKey;
    if (sortKey === currentSort) {
      const targetLink = Array.from(th.querySelectorAll('a[data-direction]'))
         .find(link => link.dataset.direction === currentDir)?.querySelector('img');
      if (targetLink) {
        targetLink.src = targetLink.src.replace('.gif', '_current.gif');
      }
    }
  });

  // ソート先を設定し、ブラウザー標準のリンク操作を維持する
  headerRow.querySelectorAll('th[data-sort-key] a[data-direction]').forEach(link => {
    const th = link.closest('th');
    const params = new URLSearchParams(window.location.search);
    params.set('sort_key', th.dataset.sortKey);
    params.set('sort_direction', link.dataset.direction);
    params.set('pageID', '1'); // ソート変更時は1ページ目に戻す
    const scriptName = headerRow.dataset.scriptName || window.location.pathname;
    link.href = `${scriptName}?${params.toString()}`;
  });
});
