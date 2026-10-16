document.addEventListener('DOMContentLoaded', () => {
  const headerRow = document.getElementById('sortable-header');
  if (!headerRow) return;

  // 1. URLSearchParams を取得
  const urlParams = new URLSearchParams(window.location.search);

  // PHPの parse_str() の挙動（後勝ち）に合わせ、重複時は最後の値を採用する
  const sortKeys = urlParams.getAll('sort_key');
  const currentSort = sortKeys[sortKeys.length - 1] || headerRow.dataset.currentSort || 'id';
  const sortDirs = urlParams.getAll('sort_direction');
  const currentDir = sortDirs[sortDirs.length - 1] || headerRow.dataset.currentDir || 'asc';

  // 2. 現在アクティブなソート項目のアイコンを _current.gif に差し替え
  const thElements = headerRow.querySelectorAll('th[data-sort-key]');
  thElements.forEach(th => {
    const sortKey = th.dataset.sortKey;
    if (sortKey === currentSort) {
      const targetLink = th.querySelector(`a[data-direction="${currentDir}"] img`);
      if (targetLink) {
        targetLink.src = targetLink.src.replace('.gif', '_current.gif');
      }
    }
  });

  // 3. クリックイベント（イベント委譲）でパラメータを付与して画面遷移
  headerRow.addEventListener('click', (event) => {
    const link = event.target.closest('a[data-direction]');
    if (!link) return;

    event.preventDefault();

    const th = link.closest('th');
    const sortKey = th.dataset.sortKey;
    const direction = link.dataset.direction;

    const params = new URLSearchParams(window.location.search);
    params.set('sort_key', sortKey);
    params.set('sort_direction', direction);
    params.set('pageID', '1'); // ソート変更時は1ページ目に戻す

    const scriptName = headerRow.dataset.scriptName || window.location.pathname;
    window.location.href = `${scriptName}?${params.toString()}`;
  });
});
