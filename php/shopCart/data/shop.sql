
CREATE DATABASE IF NOT EXISTS imooc default charset utf8;

USE imooc;

CREATE TABLE IF NOT EXISTS `imooc_pro` (
  `id` bigint(20) unsigned NOT NULL PRIMARY KEY,
  `pName` varchar(50) NOT NULL comment "商品名称",
  `pSn` varchar(50) NOT NULL comment "商品编号",
  `pNum` int(10) unsigned NOT NULL DEFAULT '1' comment "商品市库存",
  `mPrice` decimal(10,2) NOT NULL comment "商品市场价",
  `iPrice` decimal(10,2) NOT NULL comment "商品慕课价格",
  `pubTime` int NOT NULL comment "商品发布时间",
  `isShow` tinyint(1) NOT NULL DEFAULT '1' comment "商品是否上架",
  `isHot` tinyint(1) NOT NULL DEFAULT '0' comment "商品是否热卖",
  `pCost` decimal(10,2) NOT NULL comment "商品进价",
  `pDesc` mediumtext comment "商品描述",
  `cId` int(10) unsigned NOT NULL comment "分类id"
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `imooc_pro_cart` (
	`id` bigint(20) unsigned NOT NULL auto_increment PRIMARY KEY,
    `pId` bigint(20) unsigned NOT NULL comment "商品id",
	`uId` bigint(20) unsigned NOT NULL comment "用户id",
    `num` int(10) unsigned NOT NULL comment "商品数量",
    `price` decimal(10,2) NOT NULL comment "商品价格",
    `createTime` int not null comment "创建时间"
);

INSERT INTO `imooc_pro` (`id`, `pName`, `pSn`, `pNum`, `mPrice`, `iPrice` , `pubTime`, `isShow`, `isHot`, `cId`, `pCost`) VALUES
(1, '全网底价 Apple 苹果 iPad mini 16G wifi版 平板电脑 前白后银 MD531C', '9823', 245, '2500.00', '1999.00',  unix_timestamp(), 1, 0, 2, '1500.00'),
(2, '正品 Apple/苹果 9.7 英寸 iPad Pro WLAN 32GBwifi平板电脑', '9876', 245, '3288.00', '3000.00', unix_timestamp(), 1, 0, 2, '2500.00');


