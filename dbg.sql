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

-- 改的表2
alter table shop add shop_address text comment '门店地址';
alter table shop add brand varchar(100) comment '经营品牌';
alter table shop drop shop_address;
alter table shop add is_add_address tinyint default 0 comment '是否添加店铺地址';


DROP TABLE IF EXISTS `shop_address`;
CREATE TABLE `shop_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   shop_id int not null comment '商家id',
  name_ varchar(100) not null comment '门店名称',
 truename_ varchar(100) default '' comment '联系人姓名',
  mobile_ char(50) default '' comment '联系人手机',
  address_ varchar(200) default '' comment '详细地址',
  create_time int default 0,
  update_time int default 0,
 st tinyint not null default 1 comment '1正常 0删除',
  index (`shop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商户门店地址' ;


DROP TABLE IF EXISTS `withdraw`;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
   admin_id int not null comment '申请商户id',
  cach decimal(8,2) not null default 0.00 comment '申请提现金额',
   st tinyint not null default 1 comment '1待审核 2通过 3未通过', 
  cash_st tinyint not null default 1 comment '资金状态：1返还成功 2返还失败 ',
  create_time int default 0,
  update_time int default 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户申请提现表' ;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  withdraw_limit int  default 0  comment '商户申请提现最小金额',
  contact varchar(50) not null default '' comment '联系人',
  address varchar(255) not null default '' comment '平台地址',
  mobile char(11) not null default '' comment '平台电话',
  create_time int default 0,
  update_time int default 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站相关设置' ;


alter table admin add privilege varchar(255) not null default '' comment '一般管理员权限';

-- 改表3

DROP TABLE IF EXISTS `cart_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL comment '购物车id',
   shop_id int  comment '商家id',
  `good_id` int(11) NOT NULL comment '商品id,用于关联商品表',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '某个商品的数量',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  st tinyint not null default 1 comment '1正常 0删除',
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车商品表';


alter table cart add shop_id int not null  after user_id;

alter table cart drop index  user_id;

-- 改表4

alter table good add imgs text comment '商品详情文字介绍' after `desc`;
alter table good add which_info tinyint default 1 comment '商品介绍时选择图片或是文字:1文字 2图片'  after imgs;
alter table `group` rename to tuangou;
-- 改表5


DROP TABLE IF EXISTS `order_contact`;

CREATE TABLE `order_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderno` varchar(255) NOT NULL COMMENT '用于支付的订单号',
  sum_price_all decimal(10,2) default 0.00 comment '总价，可能是多个商家的',
  `st` tinyint(4) DEFAULT '1' COMMENT '0删除，1待支付 ,2已支付',

  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='多商家订单联合表(一对多)订单表';

alter table dingdan add order_contact_id int not null comment '平台订单id';
alter table order_good modify name varchar(100) not null default '' comment '商品名称';
alter table order_good modify img varchar(250) not null default '' comment '商品列表图';
-- 改表6
alter table order_good add unit varchar(50) default '' after price;
drop table if exists baoming;
 CREATE TABLE `baoming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `truename` varchar(50) NOT NULL COMMENT '报名人姓名',
  `mobile` varchar(11) NOT NULL ,
  `address` varchar(100) not null DEFAULT '' comment '报名人地址',
  `time_to` int DEFAULT '0' comment '验房时间',
  `st` tinyint(4) DEFAULT '1' COMMENT '1',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='报名（验房表）'  ;

alter table article add type tinyint not null default 1 comment '1为百科 2为验房';
alter table article add baoming_id int default 0 comment '报名id';
alter table baoming add article_st tinyint default 0 comment '是否添加了总结';

-- 改表7
alter table shop add zuoji varchar(255) not null default '' comment '座机';

alter table shop_address add zuoji varchar(255) not null default '' comment '座机';
-- 改表8
alter table dingdan add type tinyint default 1 comment '1一般订单 2限量团购订单 3限人团购订单 ';

alter table dingdan add group_id int default 0 comment '0表示不团购订单';


-- 改表9
DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动标题',
  img varchar(255) default '' comment '图片',
  `admin_id` int  NOT NULL DEFAULT 1 COMMENT '添加活动管理员',
  `start_time` int NOT NULL DEFAULT 0 comment '活动开始时间', 
  `end_time` int NOT NULL DEFAULT 0 comment '活动结束时间', 
   address varchar(255) default '' comment '活动地址',
   pnum int default 0 comment '已报名人数', 
  info text comment '内容',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线活动（平台发布）';
alter table activity add img_big varchar(255) default '' comment '大图' after img;
alter table activity add st tinyint default 1 comment '1正常 0删除';
alter table activity add charm varchar(255) default '' comment '摘要';
DROP TABLE IF EXISTS `activity_attend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_attend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int NOT NULL COMMENT '活动id',
   truename varchar(255) not null default '' comment '姓名',
  `mobile` varchar(50)  NOT NULL DEFAULT '' COMMENT '电话',
  `xiaoqu` varchar(255) not null default '' comment '小区地址',
   `nigou` varchar(100) default '' comment '拟购产品',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
   key (activity_id)
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动报名';
alter table activity_attend add zuoji varchar(50) default '' comment '座机' after mobile;
alter table setting add baoming_img_big varchar(255) default '' comment '报名宣传图';
alter table setting add baoming_logan text  comment '报名宣传语';
alter table setting add baoming_pnum text  comment '报名已参加为数';
 alter table setting modify img varchar(255) not null default '' comment '平台设置列表图片';

DROP TABLE IF EXISTS `good_img_bigs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `good_img_bigs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int NOT NULL COMMENT '商品id',
   img_big varchar(255) not null default '' comment '大图位置',
  st tinyint default 1 comment '状态：1正常 0删除',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
   key (good_id)
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品大图（多个 ）';

alter table good add img_big_st tinyint not null default 0 comment '0没有大图 1有大图';


-- 改表2017-11-7=1

alter table ad add url_to tinyint default 0  comment '链接到哪里：0无 1活动详情 2商品详情 3店铺详情 4店铺列表';
alter table ad add url_bianhao int default 0 comment '商品编号等';
-- 改表2017-11-7=2
alter table shop add deposit decimal(10,2) default 0 comment '订金';
alter table shop add money_all decimal(10,2) default '0' comment '全款';

alter table shop add youhui decimal(10,2) default '0' comment '优惠';
alter table shop add youhui_all decimal(10,2) default '0' comment '全款优惠';
alter table activity_attend add user_id int not null  after activity_id;

--2017-11-17
alter table shop add sort int default 100000 comment '排序';
alter table dingdan add refundno varchar(50) default '' comment '退款号'  ;
alter table dingdan add orderno_youhui varchar(255)  comment '抵扣单号(商品订单号)或是被抵扣单号(多个订金或是全款订单):多个以逗号分开';


--
alter table activity add type tinyint default 1 comment '1在线活动 2验房活动';

alter table activity add attend_num int default 0 comment '验房活动已参加人数';
alter table setting drop baoming_img_big;

alter table setting drop baoming_logan;
alter table setting drop baoming_pnum;
alter table setting drop wode_baoming_img;