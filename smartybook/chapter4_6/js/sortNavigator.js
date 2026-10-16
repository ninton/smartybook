document.addEventListener('DOMContentLoaded', () => {
  const headerRow = document.getElementById('sortable-header');
  if (!headerRow) return;

  // 1. URLのクエリパラメータ、またはHTMLのデータ属性から現在の状態を取得
  const urlParams = new URLSearchParams(window.location.search);
  const currentSort = urlParams.get('sort_key') || headerRow.dataset.currentSort || 'id';
  const currentDir = urlParams.get('sort_direction') || headerRow.dataset.currentDir || 'asc';

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
