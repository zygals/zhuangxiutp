-- 新改的表1：
DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL  COMMENT '参加团购的商户',
  `good_id`  int NOT NULL COMMENT '参加团购的商品',
  `pnum` int  DEFAULT 0 COMMENT '参团人数至少',
   `store` int not null comment '限定团购数量（类型为2时要添加）', 
  `price_group` decimal(10,2) NOT NULL DEFAULT '0.00' comment '团购价格',
   deposit decimal(10,2)  DEFAULT '0.00' comment '要交订金（类型为1时）', 
   end_time int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
   st tinyint default 1 comment '0删除 1正在进行 2下架 3成功 4不成功',
  type tinyint not null default 1 comment '1限人团购（要交订金） 2限时限量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购商品表';
alter table admin add income  decimal(10,2)  DEFAULT '0.00' comment '商家的收益';
 drop table groupbuy;
 drop table groupbuy_price;

