-- xampp-linux-1.7.1
-- PHP 5.2.9
-- MySQL Server 5.1.33
-- phpmyadmin 3.1.3.1
--
-- 1 phpMyAdminを表示
-- 2 SQLタブ
-- 3 SQL欄に以下をコピペ
-- 4 Goボタン

DROP DATABASE IF EXISTS smartybook;

CREATE DATABASE IF NOT EXISTS smartybook COLLATE utf8_unicode_ci;
USE smartybook;

CREATE TABLE IF NOT EXISTS `cms` (
  `id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `time` bigint(20) NOT NULL,
  `image` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

TRUNCATE TABLE `cms`;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `category`, `title`, `comment`, `time`, `image`) VALUES
(1, 'Study', '勉強初日', '先日買ってきたSmarty入門の本を開いて勉強し始めました。これから頑張るぞ。', 1199463806, './images/001.jpg'),
(2, 'Study', '勉強二日目', 'Smartyを勉強してます。ただいま一服中。', 1199465130, './images/004.jpg'),
(3, 'Eating', '今日の昼食', '東京タワーの見える公園でランチをとりました。青空の下のごはんはおいしい。', 1199469257, './images/002.jpg'),
(4, 'Work', '打ち合わせ', '同僚と案件の打ち合わせを行いました。予想外に複雑な仕様になりそうです。', 1200378462, './images/003.jpg'),
(5, 'Work', '今日の予定', '手帳を開くと今日も予定が沢山入っていて、忙しい日になりそう。\nきちんとスケジュール管理をせねば。', 1200378621, './images/005.jpg'),
(6, 'Eating', '今日の朝食', '今日の朝食はトーストとクロワッサンです。おいしそう。', 1200378693, './images/006.jpg'),
(7, 'Eating', '今日の昼食', '東京タワーの見える公園でランチをとりました。青空の下のごはんはおいしい。', 1203321453, './images/002.jpg');
