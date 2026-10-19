const menuBox = document.getElementById('menuBox');

if (menuBox) {
  // 1. サブメニューを持つ li にクラスを付与（トグルボタンは使用しない）
  const parentItems = menuBox.querySelectorAll('li:has(> ul)');
  parentItems.forEach((li) => {
    li.classList.add('has-children');
  });

  // 2. カレント要素が存在する場合、その親階層（祖先要素）をすべて自動展開
  const activeLink = menuBox.querySelector('a[aria-current="page"]');
  if (activeLink) {
    let current = activeLink.parentElement; // <li>
    while (current && current !== menuBox) {
      if (current.tagName === 'LI') {
        current.classList.add('is-expanded');
      }
      current = current.parentElement;
    }
  }
}
