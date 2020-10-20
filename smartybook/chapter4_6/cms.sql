CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `time` bigint(20) NOT NULL,
  `image` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;