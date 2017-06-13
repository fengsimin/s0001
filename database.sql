DROP TABLE IF EXISTS `s0001_admin`;
CREATE TABLE `s0001_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` tinyint(1) DEFAULT '0',
  `ctime` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0',
  `name` varchar(20) DEFAULT '',
  `pass` varchar(100) DEFAULT '',
  `face` varchar(10) DEFAULT '',
  `realname` varchar(20) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `intro` varchar(255) DEFAULT '',
  `qq` varchar(20) DEFAULT '',
  `sex` char(2) DEFAULT '',
  `rbac` varchar(255) DEFAULT '',
  `json` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `s0001_finder`;
CREATE TABLE `s0001_finder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `sortby` tinyint(1) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `size` int(11) NOT NULL DEFAULT '0',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `utime` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `s0001_finder` VALUES("1","0","0","1","61584","1467100173","0","image/jpeg","Modi-Stool-Natale-Li-Vecchi-Formabilio-5.jpg","data/finder/","jpg","1280","853",",1,");
INSERT INTO `s0001_finder` VALUES("2","0","0","1","26695","1467100173","0","image/jpeg","Modi-Stool-Natale-Li-Vecchi-Formabilio-3.jpg","data/finder/","jpg","1280","853",",2,");


DROP TABLE IF EXISTS `s0001_item`;
CREATE TABLE `s0001_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `nid` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `sortby` int(11) NOT NULL DEFAULT '100',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `utime` int(11) NOT NULL DEFAULT '0',
  `price` varchar(10) NOT NULL,
  `price2` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `color` varchar(1000) NOT NULL,
  `thumb` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `introduce` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `s0001_item` VALUES("1","0","2","1","100","1467101158","1490526640","199.0","250.0","MAGIC INSTRUMENTS","","","a:4:{s:5:\"image\";a:3:{i:0;s:11:\"color01.jpg\";i:1;s:11:\"color03.jpg\";i:2;s:11:\"color02.jpg\";}s:5:\"width\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:6:\"height\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:5:\"title\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}}","a:4:{s:5:\"image\";a:3:{i:0;s:15:\"pic01-thumb.jpg\";i:1;s:15:\"pic03-thumb.jpg\";i:2;s:15:\"pic02-thumb.jpg\";}s:5:\"width\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:6:\"height\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:5:\"title\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}}","a:4:{s:5:\"image\";a:3:{i:0;s:9:\"pic01.jpg\";i:1;s:9:\"pic03.jpg\";i:2;s:9:\"pic02.jpg\";}s:5:\"width\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:6:\"height\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}s:5:\"title\";a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}}","data/item/1","What could have been just a simple wooden stool made out of steamed beech wood is instead a modern stool outfitted with colorful metal details. Modì, by Natale Li Vecchi for Formabilio...","&lt;p&gt;The wood structure and the steel seat and footrest are coated with a water-based varnish, making the stool work outdoors. The Mod&amp;igrave; is available in light orange, white, or aquamarine.&lt;/p&gt;\n&lt;p&gt;&lt;img src=&quot;data/finder/Modi-Stool-Natale-Li-Vecchi-Formabilio-3.jpg&quot; width=&quot;1280&quot; height=&quot;853&quot; /&gt;&lt;/p&gt;\n&lt;p&gt;&lt;img class=&quot;&quot; src=&quot;data/finder/Modi-Stool-Natale-Li-Vecchi-Formabilio-5.jpg&quot; alt=&quot;&quot; width=&quot;1280&quot; height=&quot;853&quot; /&gt;&lt;/p&gt;");


DROP TABLE IF EXISTS `s0001_log`;
CREATE TABLE `s0001_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT '0',
  `state` tinyint(1) DEFAULT '0',
  `ctime` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0',
  `admin_name` varchar(20) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `table` varchar(20) DEFAULT '',
  `table_id` int(11) DEFAULT '0',
  `ip` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `s0001_order`;
CREATE TABLE `s0001_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `nid` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `sortby` int(11) NOT NULL DEFAULT '100',
  `ctime` int(11) NOT NULL DEFAULT '0',
  `utime` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `sn` varchar(20) NOT NULL,
  `color` varchar(255) NOT NULL,
  `total` varchar(10) NOT NULL,
  `linkman` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_price` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `s0001_order` VALUES("1","0","3","0","100","1483079932","0","1","1612301438529869","http://qing.com/s0001/data/item/1/color03.jpg","199.0","123213","15815744775","河北省 秦皇岛市 北戴河区 234325","","MAGIC INSTRUMENTS","199.0");
INSERT INTO `s0001_order` VALUES("2","0","3","0","100","1494495422","0","2","1705111737022732","http://qing.com/s0001/data/item/1/color02.jpg","398.0","tset","17088474785","山西省 阳泉市 矿区 asdfsdf","","MAGIC INSTRUMENTS","199.0");


DROP TABLE IF EXISTS `s0001_site`;
CREATE TABLE `s0001_site` (
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `s0001_site` VALUES("1","description","");
INSERT INTO `s0001_site` VALUES("1","domain","qing.com/s0001");
INSERT INTO `s0001_site` VALUES("1","favicon","favicon.png");
INSERT INTO `s0001_site` VALUES("1","keywords","");
INSERT INTO `s0001_site` VALUES("1","logo","");
INSERT INTO `s0001_site` VALUES("1","site_name","");
INSERT INTO `s0001_site` VALUES("1","skin","");
INSERT INTO `s0001_site` VALUES("1","style","");
INSERT INTO `s0001_site` VALUES("1","title","s0001");
INSERT INTO `s0001_site` VALUES("1","touch_icon","");


DROP TABLE IF EXISTS `s0001_stats`;
CREATE TABLE `s0001_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `screen` varchar(20) DEFAULT '',
  `cookie` varchar(32) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `referer` varchar(255) DEFAULT '',
  `keyword` varchar(255) DEFAULT '',
  `os` varchar(20) DEFAULT '',
  `os_version` varchar(20) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `browser` varchar(20) DEFAULT '',
  `browser_version` varchar(20) DEFAULT '',
  `ip` varchar(20) DEFAULT '',
  `ip_isp` varchar(20) DEFAULT '',
  `ip_country` varchar(20) DEFAULT '',
  `ip_region` varchar(20) DEFAULT '',
  `ip_area` varchar(20) DEFAULT '',
  `ip_city` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `s0001_trash`;
CREATE TABLE `s0001_trash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` tinyint(1) DEFAULT '0',
  `ctime` int(11) DEFAULT '0',
  `utime` int(11) DEFAULT '0',
  `admin_id` int(11) DEFAULT '0',
  `admin_name` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `note` varchar(255) DEFAULT '',
  `table` varchar(255) DEFAULT '',
  `data` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



