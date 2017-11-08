-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: zhuangxiu
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动标题',
  `img` varchar(255) DEFAULT '' COMMENT '图片',
  `img_big` varchar(255) DEFAULT '' COMMENT '大图',
  `admin_id` int(11) NOT NULL DEFAULT '1' COMMENT '添加活动管理员',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `address` varchar(255) DEFAULT '' COMMENT '活动地址',
  `pnum` int(11) DEFAULT '0' COMMENT '已报名人数',
  `info` text COMMENT '内容',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) DEFAULT '1' COMMENT '1正常 0删除',
  `charm` varchar(255) DEFAULT '' COMMENT '摘要',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='在线活动（平台发布）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,'houdong1','/upload/activity/20171105/97d68cf1498737d961714a2bbc40df41.png','',1,1509811200,1510070400,'bijingtiyugaunff',0,'asdgadgsaw3e',1509854592,1509855657,1,''),(2,'huo2','/upload/activity/20171105/117dde0439fa2b3278fede48aa881f59.png','',1,1509552000,1509724800,'adsfdizhi2222222',0,'adsgadgadlhkahsdf\r\nhkahsdgadg\r\n',1509855201,1509855201,1,''),(3,'now111','/upload/activity/20171105/61c6d681ccc31740378d5dc5755ecea0.png','/upload/activity/20171105/ba054f68f3a54d72da2d8e57d48476fd.png',1,1509724800,1510329600,'adfasdfa23434',8,'adsfsadgagdg',1509856998,1509858705,1,'adsgadgs'),(4,'tupain','/upload/activity/20171105/4cf333f64de1b23163ba8697941db871.png','/upload/activity/20171105/9aeb37188ca0c6b322f33c0cc37212c4.png',1,1484150400,1512057600,'akjdf',0,'adfsagadg',1509858650,1509858693,1,'adgsasdg');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_attend`
--

DROP TABLE IF EXISTS `activity_attend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_attend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `user_id` int(11) NOT NULL,
  `truename` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `zuoji` varchar(50) DEFAULT '' COMMENT '座机',
  `xiaoqu` varchar(255) NOT NULL DEFAULT '' COMMENT '小区地址',
  `nigou` varchar(100) DEFAULT '' COMMENT '拟购产品',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='活动报名';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_attend`
--

LOCK TABLES `activity_attend` WRITE;
/*!40000 ALTER TABLE `activity_attend` DISABLE KEYS */;
INSERT INTO `activity_attend` VALUES (1,4,0,'adf','134783435','0-9-3425','skdfjag','',0,0),(2,3,0,'adf','134783435','0-9-3425','skdfjag','',1509860053,1509860053),(3,3,0,'adf','134783435','0-9-3425','skdfjag','',1509865687,1509865687),(4,3,0,'adf','134783435','0-9-3425','skdfjag','',1509867698,1509867698),(5,3,1,'adsfer','8888888','','xiauqqqq','',1510045463,1510047111),(6,3,1,'adsfer','8888888','','xiauqqqq','',1510047012,1510047111),(7,3,1,'adsfer','8888888','','xiauqqqq','',1510047025,1510047111),(8,3,1,'adsfer','8888888','','xiauqqqq','',1510047027,1510047111),(9,3,1,'adsfer','8888888','','xiauqqqq','',1510047047,1510047111),(10,3,1,'adsfer','8888888','','xiauqqqq','',1510047061,1510047111);
/*!40000 ALTER TABLE `activity_attend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ad`
--

DROP TABLE IF EXISTS `ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片保存路径',
  `url` varchar(100) DEFAULT '',
  `position` tinyint(4) NOT NULL DEFAULT '1' COMMENT '所处位置：1首页 ',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0删除状态,1正常，2不显示',
  `sort` tinyint(4) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `url_to` tinyint(4) DEFAULT '0' COMMENT '链接到哪里：0无1活动详情 2商品详情 3店铺详情 4店铺列表',
  `url_bianhao` int(11) DEFAULT '0' COMMENT '商品编号等',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='广告图／轮播图表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad`
--

LOCK TABLES `ad` WRITE;
/*!40000 ALTER TABLE `ad` DISABLE KEYS */;
INSERT INTO `ad` VALUES (53,'ad1','/upload/ad/20171018/e49b1da9f01d620f5ec6684a5c8cef15.png','',1,1,0,1508304667,1508304682,0,0),(54,'urlad1','/upload/ad/20171107/2e5db26d916d980606f6035cc32d7548.png','/pages/activity_detail/activity_detail?id=1',1,1,1,1510018584,1510018584,1,0),(55,'urlad2','/upload/ad/20171107/5e431c9957bf546adc9beebcb29e8f15.png','/pages/goods/goods',1,1,0,1510018838,1510018838,4,0),(56,'ulrad3','/upload/ad/20171107/34be487fd6217f92c33f4e83eab0d141.png','',1,1,0,1510018850,1510018850,0,0),(57,'ad3','/upload/ad/20171107/bcbdf9fd864c22d486377ef196458ee8.png','/pages/store/store?shop_id=8',1,1,1,1510019386,1510019536,3,8),(58,'fadsg','/upload/ad/20171107/862c66621759435ec0884d229476896d.png','/pages/bDetail/bDetail?good_id=1213',1,1,0,1510022133,1510022133,2,1213);
/*!40000 ALTER TABLE `ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `truename` varchar(50) NOT NULL,
  `mobile` char(11) NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1为默认收货地址 0为其他',
  `pcd` varchar(100) NOT NULL DEFAULT '',
  `info` varchar(100) NOT NULL COMMENT '收货地址其它信息',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0删除 1正常',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='收货人地址表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,1,'李芯在','13566988888',0,'广东省广州市天河区','纟弛小区4号3层',NULL,NULL,1);
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '账号',
  `truename` varchar(50) DEFAULT '',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `pwd` char(32) DEFAULT NULL COMMENT '密码',
  `times` int(11) DEFAULT '0' COMMENT '登录次数',
  `type` tinyint(4) DEFAULT '2' COMMENT '1超级 2一般(店铺管理员)',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) DEFAULT '1',
  `income` decimal(10,2) DEFAULT '0.00' COMMENT '商家的收益',
  `privilege` varchar(255) NOT NULL DEFAULT '' COMMENT '一般管理员权限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理员（超级及一般）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','',0,'29c4f82544e320e4b10eac802dc68659',52,1,0,1508377282,1,0.00,''),(2,'admin_shop1','asdg',12,'e43246d6459ffdc4f5705dbedd00b42e',2,2,1508227949,1508380727,1,0.00,''),(3,'shopadmin2','商家姓名2',10,'e43246d6459ffdc4f5705dbedd00b42e',14,2,1508229830,1508909610,1,10000.00,''),(4,'admin2','asdg',0,'671467d49d5cc0bca499ff444ee0e9f1',4,3,1508576438,1508581247,1,0.00,'22,11,2,7'),(5,'admin3','',0,'671467d49d5cc0bca499ff444ee0e9f1',0,3,1510024496,1510024496,1,0.00,'24,7'),(6,'admin444','dff',0,'671467d49d5cc0bca499ff444ee0e9f1',0,3,1510024528,1510024528,1,0.00,'25,21');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '1' COMMENT 'admin_id',
  `ip` varchar(50) DEFAULT '' COMMENT '上次登录ip',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8 COMMENT='后台管理员登录日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
INSERT INTO `admin_log` VALUES (93,3,'::1',1508204806,1508204806),(94,3,'::1',1508204885,1508204885),(95,3,'::1',1508216647,1508216647),(96,1,'::1',1508291605,1508291605),(97,3,'127.0.0.1',1508299247,1508299247),(98,3,'127.0.0.1',1508299761,1508299761),(99,1,'::1',1508302355,1508302355),(100,3,'127.0.0.1',1508307611,1508307611),(101,1,'::1',1508307740,1508307740),(102,1,'::1',1508308014,1508308014),(103,1,'::1',1508308892,1508308892),(104,1,'::1',1508308978,1508308978),(105,1,'::1',1508309324,1508309324),(106,3,'127.0.0.1',1508309345,1508309345),(107,3,'::1',1508309527,1508309527),(108,1,'::1',1508309565,1508309565),(109,3,'::1',1508309580,1508309580),(110,1,'::1',1508310347,1508310347),(111,3,'::1',1508310387,1508310387),(112,1,'::1',1508310503,1508310503),(113,1,'::1',1508376078,1508376078),(114,1,'::1',1508377250,1508377250),(115,1,'::1',1508377289,1508377289),(116,1,'::1',1508388701,1508388701),(117,1,'::1',1508403292,1508403292),(118,3,'::1',1508403974,1508403974),(119,1,'::1',1508405820,1508405820),(120,3,'::1',1508405863,1508405863),(121,1,'::1',1508406671,1508406671),(122,3,'::1',1508406732,1508406732),(123,3,'::1',1508407078,1508407078),(124,1,'::1',1508407148,1508407148),(125,2,'::1',1508407191,1508407191),(126,1,'::1',1508461451,1508461451),(127,1,'::1',1508476264,1508476264),(128,1,'::1',1508480825,1508480825),(129,3,'::1',1508480893,1508480893),(130,1,'::1',1508484347,1508484347),(131,3,'::1',1508486639,1508486639),(132,1,'::1',1508486690,1508486690),(133,1,'::1',1508548460,1508548460),(134,1,'::1',1508563335,1508563335),(135,4,'::1',1508580155,1508580155),(136,1,'127.0.0.1',1508581158,1508581158),(137,4,'127.0.0.1',1508581180,1508581180),(138,1,'127.0.0.1',1508581239,1508581239),(139,4,'127.0.0.1',1508581272,1508581272),(140,1,'::1',1508581373,1508581373),(141,1,'::1',1508581416,1508581416),(142,4,'127.0.0.1',1508581455,1508581455),(143,1,'::1',1508720900,1508720900),(144,1,'::1',1508723118,1508723118),(145,1,'::1',1508730982,1508730982),(146,1,'::1',1508735028,1508735028),(147,1,'::1',1508737494,1508737494),(148,1,'::1',1508809692,1508809692),(149,1,'::1',1508828025,1508828025),(150,1,'::1',1508895155,1508895155),(151,1,'::1',1508907151,1508907151),(152,3,'::1',1508909579,1508909579),(153,1,'::1',1508909629,1508909629),(154,1,'::1',1508979248,1508979248),(155,1,'::1',1508984636,1508984636),(156,1,'::1',1508989875,1508989875),(157,1,'::1',1508994723,1508994723),(158,1,'::1',1509174647,1509174647),(159,1,'::1',1509853780,1509853780),(160,1,'::1',1509865070,1509865070),(161,1,'::1',1509934507,1509934507),(162,1,'::1',1510015897,1510015897),(163,2,'::1',1510024788,1510024788),(164,1,'::1',1510024882,1510024882),(165,1,'::1',1510031340,1510031340),(166,1,'::1',1510042156,1510042156);
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) DEFAULT '1' COMMENT '文章分类id',
  `name` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL DEFAULT '',
  `cont` text NOT NULL,
  `charm` varchar(255) NOT NULL DEFAULT '',
  `clicks` int(11) NOT NULL DEFAULT '1',
  `admin_id` tinyint(4) NOT NULL DEFAULT '1',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0删除状态,1正常，2不显示',
  `index_show` tinyint(4) DEFAULT '0' COMMENT '首页推荐',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1为百科 2为验房 3为团购活动',
  `baoming_id` int(11) DEFAULT '0' COMMENT '报名id',
  `tuangou_id` int(11) DEFAULT NULL COMMENT '团购活动总结',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,4,'gaike11','/upload/article/20171023/5452d8160ec0c7a175467b4acec1d18c.png','asdf52q45agsg','',1,1,1,0,1508725569,1508725569,1,0,NULL);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baoming`
--

DROP TABLE IF EXISTS `baoming`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baoming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `truename` varchar(50) NOT NULL COMMENT '报名人姓名',
  `mobile` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '报名人地址',
  `time_to` int(11) DEFAULT '0' COMMENT '验房时间',
  `st` tinyint(4) DEFAULT '1' COMMENT '1',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `article_st` tinyint(4) DEFAULT '0' COMMENT '是否添加了总结',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='报名（验房表）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baoming`
--

LOCK TABLES `baoming` WRITE;
/*!40000 ALTER TABLE `baoming` DISABLE KEYS */;
INSERT INTO `baoming` VALUES (1,1,'dufj_8d','13888888','jjjjjj',0,1,0,1510043637,0);
/*!40000 ALTER TABLE `baoming` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `sum_price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1表示有商品，0表示没有',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,1,10,0.00,1508829106,1509089026,1),(3,1,12,0.00,1508829598,1509089305,0);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_good`
--

DROP TABLE IF EXISTS `cart_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL COMMENT '购物车id',
  `shop_id` int(11) DEFAULT NULL COMMENT '商家id',
  `good_id` int(11) NOT NULL COMMENT '商品id,用于关联商品表',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '某个商品的数量',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0删除',
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='购物车商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_good`
--

LOCK TABLES `cart_good` WRITE;
/*!40000 ALTER TABLE `cart_good` DISABLE KEYS */;
INSERT INTO `cart_good` VALUES (1,1,10,13,3,1508829106,1509089026,0),(2,3,12,15,2,1508829598,1509089183,0),(3,3,12,16,4,1508829760,1509089305,0);
/*!40000 ALTER TABLE `cart_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cate`
--

DROP TABLE IF EXISTS `cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '名称',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1装修 2百科',
  `sort` tinyint(4) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cate`
--

LOCK TABLES `cate` WRITE;
/*!40000 ALTER TABLE `cate` DISABLE KEYS */;
INSERT INTO `cate` VALUES (1,'涂料',1508207929,1508209805,1,1,1),(2,'地板',1508209839,1508209839,1,1,0),(3,'瓷砖',1508212043,1508212043,1,1,2),(4,'baike1',1508488243,1508488243,1,2,0);
/*!40000 ALTER TABLE `cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collect`
--

DROP TABLE IF EXISTS `collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `collect_id` int(11) NOT NULL,
  `st` tinyint(4) DEFAULT '1' COMMENT '1收藏 0不收藏',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `type` tinyint(4) NOT NULL COMMENT '1收藏商品id 2收藏店铺id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collect`
--

LOCK TABLES `collect` WRITE;
/*!40000 ALTER TABLE `collect` DISABLE KEYS */;
/*!40000 ALTER TABLE `collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dingdan`
--

DROP TABLE IF EXISTS `dingdan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dingdan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL,
  `orderno` varchar(50) NOT NULL COMMENT '订单编号',
  `user_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT '0',
  `sum_price` decimal(10,2) DEFAULT '0.00',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `goodst` tinyint(4) NOT NULL DEFAULT '1',
  `st` tinyint(4) DEFAULT '1' COMMENT '1没支付  2完成支付 3取消 4退款',
  `order_contact_id` int(11) NOT NULL COMMENT '平台订单id',
  `type` tinyint(4) DEFAULT '1' COMMENT '1一般订单 2限量团购订单 3限人团购订单 ',
  `group_id` int(11) DEFAULT '0' COMMENT '0表示不团购订单',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orderno` (`orderno`),
  KEY `user_id` (`user_id`,`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dingdan`
--

LOCK TABLES `dingdan` WRITE;
/*!40000 ALTER TABLE `dingdan` DISABLE KEYS */;
INSERT INTO `dingdan` VALUES (1,10,'asdf2463132',1,1,32.30,0,0,1,1,0,1,0);
/*!40000 ALTER TABLE `dingdan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fankui`
--

DROP TABLE IF EXISTS `fankui`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fankui` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `cont` varchar(255) DEFAULT '',
  `st` tinyint(4) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='反馈表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fankui`
--

LOCK TABLES `fankui` WRITE;
/*!40000 ALTER TABLE `fankui` DISABLE KEYS */;
INSERT INTO `fankui` VALUES (1,1,13,1,'goodgood!...asdgaga657sdf98a1321',1,0,1508322145);
/*!40000 ALTER TABLE `fankui` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good`
--

DROP TABLE IF EXISTS `good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '名称',
  `store` int(11) DEFAULT '1' COMMENT '库存数量',
  `sales` int(11) DEFAULT '0' COMMENT '销量，商品发货后增加',
  `cate_id` int(11) NOT NULL DEFAULT '1' COMMENT '分类id',
  `shop_id` int(11) NOT NULL DEFAULT '1' COMMENT '店铺id',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '列表图',
  `img_big` varchar(255) NOT NULL DEFAULT '' COMMENT '大图',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `desc` text COMMENT '描述',
  `imgs` text COMMENT '商品详情文字介绍',
  `which_info` tinyint(4) DEFAULT '1' COMMENT '商品介绍时选择图片或是文字:1文字 2图片',
  `is_add_attr` tinyint(4) DEFAULT '0' COMMENT '是否添加参数',
  `st` tinyint(4) DEFAULT '1' COMMENT '0删除， 1正常 ,2不显示',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `to_top` tinyint(4) DEFAULT '0' COMMENT '1置顶 0不置顶',
  `unit` varchar(30) NOT NULL COMMENT '计量单位',
  `img_big_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0没有大图 1有大图',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`,`shop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='资料表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good`
--

LOCK TABLES `good` WRITE;
/*!40000 ALTER TABLE `good` DISABLE KEYS */;
INSERT INTO `good` VALUES (11,'32adsg',1,0,1,11,'/upload/good/20171018/20b5450baea72932e313608d9892569f.png','/upload/good/20171018/4bab1313e198e2fff5ccd6534e3f9778.png',23.00,'adsgasg',NULL,1,0,1,1508297794,1508384131,0,'',0),(12,'shangpin2',1,0,3,10,'/upload/good/20171018/c469580704d806b703fe160801162e6e.png','/upload/good/20171018/4322e57cfb433d728d2b25412fe7eb67.png',3.20,'asdfasgag',NULL,1,0,1,1508315812,1508385518,1,'',0),(13,'商户2的商品1',1,0,3,10,'/upload/good/20171019/e48b31796f79f76c5ce301f67acf09be.png','/upload/good/20171019/6e496619b6f523c53b5548a9fbdd3be3.png',2.10,'adfsr235as4g56a4sg\r\nasg35a57st8qwyljdasfoiag ',NULL,1,0,1,1508378146,1508400779,1,'',0),(14,'商户有2的商品2',1,0,3,10,'/upload/good/20171019/2f13b5515e44de09f636f9d293e97ab9.png','/upload/good/20171019/06cb82ecf47515a7ba4dae6a16175388.png',0.23,'adfadf23424',NULL,1,0,1,1508379707,1508462940,0,'',0),(15,'商家名称1－商品1',1,0,1,9,'/upload/good/20171024/15b6ee981fe4b815c218addd4a62729d.png','/upload/good/20171024/c07e98362e0848acd6e21b87c4c008b4.png',3.10,'asdgas245436',NULL,1,0,1,1508829355,1508829355,0,'',0),(16,'商家名称1－商品2',1,0,1,9,'/upload/good/20171024/2b20f42ba2d31f537dd79111192057f0.png','/upload/good/20171024/0ec4fb0da9e4e99d96b69c82865b3003.png',1.00,'adfs24agasd4654a65d4sg\r\n',NULL,1,0,1,1508829384,1508829384,0,'',0),(17,'good-info',1,0,1,9,'/upload/good_img/20171025/99163f4a062fb2b7edee2e541b62674f.png','/upload/good_img_big/20171025/13a6a7fa90f1287ef6fd163cd36ff335.png',2.30,'','/upload/good_imgs/20171025/d66fe14c31516580f2dfea15b80ebc56.png',2,0,1,1508900737,1508902816,0,'m',0),(18,'good-imgs',1,0,1,9,'/upload/good_img/20171025/c3e608d471f4140c22f45b15874241bb.png','/upload/good_img_big/20171025/e2dff47f68413dd9aa1349081beff7c4.png',2.50,'adasrt54q2adghah3434','',1,0,1,1508901043,1509873776,0,'m2',0),(19,'gsdgsg',1,0,3,10,'/upload/good_img/20171025/31d548ac574155ec30ee8a529b0aefd3.png','/upload/good_img_big/20171025/4eb171155c2b041aef3e66d8b50ac12a.png',234.00,'','/upload/good_imgs/20171025/21a118e4f0f81625d1f1bbb961c7911d.png',2,0,1,1508902871,1509873402,0,'df',1),(20,'a45g',1,0,1,12,'/upload/good/20171026/0af067c1eb5ae3f2ab96ec5f20ef382b.png','/upload/good_img_big/20171025/2d5fbee280c5141ad13052a72117cad5.png',34.00,'不要图。要议院','',1,0,1,1508902933,1509871871,0,'gh',1);
/*!40000 ALTER TABLE `good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_img_bigs`
--

DROP TABLE IF EXISTS `good_img_bigs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `good_img_bigs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL COMMENT '商品id',
  `img_big` varchar(255) NOT NULL DEFAULT '' COMMENT '大图位置',
  `st` tinyint(4) DEFAULT '1' COMMENT '状态：1正常 0删除',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='商品大图（多个 ）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_img_bigs`
--

LOCK TABLES `good_img_bigs` WRITE;
/*!40000 ALTER TABLE `good_img_bigs` DISABLE KEYS */;
INSERT INTO `good_img_bigs` VALUES (1,20,'/upload/good_img_big/20171105/1db7059670a98a80143c0ef91b72fcfa.png',0,0,0),(2,20,'/upload/good_img_big/20171105/792fbf95f04b91902feea35f0884a8f0.png',0,0,0),(3,20,'/upload/good_img_big/20171105/bc8ac70c44c15bc322593b60bc99b819.png',0,0,0),(4,19,'/upload/good_img_big/20171105/32efb9a7f028be5b6401a472f74ba41c.png',0,0,0),(5,19,'/upload/good_img_big/20171105/435f11560d2ace0ed6c740b2c1b2fc5e.png',0,0,0),(6,18,'/upload/good_img_big/20171105/d2db8b3721bbc44ccb9218d6623af0d9.png',0,0,0),(7,18,'/upload/good_img_big/20171105/bf06831ffbf94b83965e2cea27123ad8.png',0,0,0);
/*!40000 ALTER TABLE `good_img_bigs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_admin`
--

DROP TABLE IF EXISTS `menu_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '导航名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '导航上级id，总分两级,0表示一级',
  `controller` varchar(100) DEFAULT '' COMMENT '控制器,为一级时为""',
  `action` varchar(100) DEFAULT '' COMMENT '控制器中方法,为一级时为""',
  `param` varchar(100) DEFAULT '' COMMENT '参数',
  `sort` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `is_show_to_shop` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1展示 0不展示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='后台左侧导航';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_admin`
--

LOCK TABLES `menu_admin` WRITE;
/*!40000 ALTER TABLE `menu_admin` DISABLE KEYS */;
INSERT INTO `menu_admin` VALUES (1,'主要管理',0,'','','',1,1499926154,1499926154,1),(2,'商户/百科分类',1,'Cate','index','',3,1499926628,1508378626,0),(4,'团购',1,'Group','index','',6,1499929021,1508728124,1),(25,'在线活动',1,'Activity','index','',0,1509853809,1509853809,1),(6,'装修百科',1,'Article','index','',5,1499931757,1508307233,0),(7,'评价',8,'Fankui','index','',4,1500019957,1508147217,1),(8,'订单管理',0,'','','',2,1500281130,1502343485,1),(9,'广告图',1,'Ad','index','',7,1500281153,1508307068,0),(11,'订单',8,'Dingdan','index','',1,1500353254,1502343547,1),(14,'其它管理',0,'','','',3,1500451917,1502343607,1),(15,'管理员',14,'Admin','index','',2,1500452020,1508571890,0),(21,'小程序用户',8,'User','index','',2,1502338116,1508378651,0),(22,'商品',1,'Good','index','',0,1508147129,1508147129,1),(19,'商户',1,'Shop','index','',1,1501834139,1508145685,1),(24,'提现管理',8,'Withdraw','index','',0,1508909448,1508909448,1),(26,'设置',14,'Setting','index','',0,1509860334,1509860334,1),(27,'验房报名',1,'Baoming','index','',0,1510043378,1510043378,1);
/*!40000 ALTER TABLE `menu_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_activity`
--

DROP TABLE IF EXISTS `online_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动标题',
  `img` varchar(255) DEFAULT '' COMMENT '图片',
  `admin_id` int(11) NOT NULL DEFAULT '1' COMMENT '添加活动管理员',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `address` varchar(255) DEFAULT '' COMMENT '活动地址',
  `pnum` int(11) DEFAULT '0' COMMENT '已报名人数',
  `info` text COMMENT '内容',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线活动（平台发布）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_activity`
--

LOCK TABLES `online_activity` WRITE;
/*!40000 ALTER TABLE `online_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_contact`
--

DROP TABLE IF EXISTS `order_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderno` varchar(255) NOT NULL COMMENT '用于支付的订单号',
  `sum_price_all` decimal(10,2) DEFAULT '0.00' COMMENT '总价，可能是多个商家的',
  `st` tinyint(4) DEFAULT '1' COMMENT '0删除，1待支付 ,2已支付',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='多商家订单联合表(一对多)订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_contact`
--

LOCK TABLES `order_contact` WRITE;
/*!40000 ALTER TABLE `order_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_good`
--

DROP TABLE IF EXISTS `order_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `st` tinyint(4) NOT NULL DEFAULT '1',
  `img` varchar(250) NOT NULL DEFAULT '' COMMENT '商品列表图',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `price` decimal(10,2) DEFAULT '0.00',
  `unit` varchar(50) DEFAULT '',
  `shop_id` int(11) NOT NULL,
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_good`
--

LOCK TABLES `order_good` WRITE;
/*!40000 ALTER TABLE `order_good` DISABLE KEYS */;
INSERT INTO `order_good` VALUES (1,1,11,2,2,'0','0',0.00,'',0,0,0),(2,1,12,3,2,'0','0',0.00,'',0,0,0);
/*!40000 ALTER TABLE `order_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `withdraw_limit` int(11) DEFAULT '0' COMMENT '商户申请提现最小金额',
  `contact` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '平台地址',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '平台电话',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '平台设置列表图片',
  `telephone` varchar(10) DEFAULT NULL COMMENT '座机号码',
  `baoming_img_big` varchar(255) DEFAULT '' COMMENT '报名宣传图',
  `baoming_logan` text COMMENT '报名宣传语',
  `baoming_pnum` text COMMENT '报名已参加为数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站相关设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,122,'','','',1509861635,1509862212,'/upload/setting/20171105/7f67b14ae2736a4fcc57f05199dbe321.png','','/upload/setting/20171105/6ff07ff6133ab2651fcb7df97d7e0920.png','xuanchaungyuxuanchaungyuxuanchaungyuxuanchaungyuxuanchaungyuxuanchaungyuxuanchaungyu','346');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL COMMENT '名',
  `addr` varchar(50) NOT NULL DEFAULT '1' COMMENT '所在地址',
  `city` varchar(50) DEFAULT NULL COMMENT '所在城市',
  `cate_id` int(11) NOT NULL,
  `truename` varchar(50) DEFAULT '1' COMMENT '店铺联系人真实姓名',
  `phone` char(11) DEFAULT '',
  `ordernum` int(11) NOT NULL DEFAULT '0' COMMENT '订单量',
  `tradenum` int(11) NOT NULL DEFAULT '0' COMMENT '交易量',
  `fankuinum` int(11) DEFAULT NULL COMMENT '评价数',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '列表图',
  `logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `img_big` varchar(255) NOT NULL DEFAULT '' COMMENT '大图',
  `st` tinyint(4) DEFAULT '1' COMMENT '0不显示，1正常 ,2删除',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `info` text COMMENT '商品详情文字介绍',
  `to_top` tinyint(4) DEFAULT '0' COMMENT '1置顶 0不置顶',
  `brand` varchar(100) DEFAULT NULL COMMENT '经营品牌',
  `is_add_address` tinyint(4) DEFAULT '0' COMMENT '是否添加店铺地址',
  `zuoji` varchar(255) NOT NULL DEFAULT '' COMMENT '座机',
  `deposit` decimal(10,2) DEFAULT '0.00' COMMENT '订金',
  `money_all` decimal(10,2) DEFAULT '0.00' COMMENT '全款',
  `youhui` decimal(10,2) DEFAULT '0.00' COMMENT '优惠',
  `youhui_all` decimal(10,2) DEFAULT '0.00' COMMENT '全款优惠',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='店铺表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop`
--

LOCK TABLES `shop` WRITE;
/*!40000 ALTER TABLE `shop` DISABLE KEYS */;
INSERT INTO `shop` VALUES (9,NULL,'商户名称1','河北石家庄',NULL,1,'商家姓名1','15899845520',0,0,NULL,'/upload/shop/20171017/5164757c36e1ab79d111fca450cb4c7e.png',NULL,'/upload/shop/20171017/46c0ebc0f2ba0251e54ac662093df44f.png',1,1508216839,1508216839,NULL,0,NULL,0,'',0.00,0.00,0.00,0.00),(10,3,'商户名称2','河北石家庄','石家庄',3,'商家姓名2','15899225520',0,0,NULL,'/upload/shop/20171017/6e2f9cf64be7278fdd5ef1d2f1d35e83.png','/upload/shop/20171019/cfbff7de51057bf7b50fa3cb4ae89c9c.png','/upload/shop/20171017/076db30d077cbdffe8785d958f10a882.png',1,1508223101,1508481259,NULL,0,NULL,0,'',0.00,0.00,0.00,0.00),(11,NULL,'agsdg','adfcx2525',NULL,2,'地板出不','13244232421',0,0,NULL,'/upload/shop/20171017/8b97c6aebb50ea72dbbd83762f723749.png',NULL,'/upload/shop/20171017/345d8dedc87d12032dd9ba0782ae4f26.png',1,1508223861,1508567588,NULL,0,NULL,0,'',0.00,0.00,0.00,0.00),(12,2,'商家名称11','adadf','北京',1,'地板出不ab','13244533412',0,0,NULL,'/upload/shop/20171017/ea5d2eca586d45fe28cb8aab066b7300.png',NULL,'/upload/shop/20171017/47eb7e0e6d43057eb95d9fe81586c137.png',1,1508223906,1508896257,NULL,0,'brand1,brand2.',0,'',0.00,0.00,0.00,0.00),(13,NULL,'dfasdf','af234asdg','beijingdf',2,'asdf234','13423112343',0,0,NULL,'/upload/shop/20171018/c53dfcdfbfe99e8c1980c86fb11b750f.png','/upload/shop/20171018/5efc3af38a5404d416019520bb1f9c90.png','',1,1508293201,1508382651,NULL,1,NULL,0,'',0.00,0.00,0.00,0.00),(14,NULL,'shop_adress-test','时限区df dlkdf不吧男','北京',2,'tuliao','13566548897',0,0,NULL,'/upload/shop/20171021/4570a7756cda8a822e8f7b12220f10e8.png','/upload/shop/20171021/67fec4a65e445d75ddd5cf372ac738ea.png','',1,1508557619,1508567367,NULL,0,'品牌1',0,'',0.00,0.00,0.00,0.00),(15,NULL,'adf ','asdgasdg245','asdgasg',2,'adgg','13223212345',0,0,NULL,'/upload/shop/20171021/adee20501a215036a5bb87bbf19cf240.png','/upload/shop/20171021/4aed9e7cff32560f28d8792bf63d07ef.png','',1,1508558363,1508570045,NULL,0,'adfasdf',0,'',0.00,0.00,0.00,0.00),(16,NULL,'adf ','asdgasdg245','asdgasg',2,'adgg','13223212345',0,0,NULL,'/upload/shop/20171021/b47ae9f4accd6e7bce0026aa6f513a9d.png','/upload/shop/20171021/2f55893e397ed9c42342a556106cd1c2.png','',1,1508558410,1508558410,NULL,0,'adfasdf',0,'',0.00,0.00,0.00,0.00),(17,NULL,'adf ','asdgasdg245','asdgasg',2,'adgg','13223212345',0,0,NULL,'/upload/shop/20171021/32123c26f5eba74270f220de0d9738b5.png','/upload/shop/20171021/32123c26f5eba74270f220de0d9738b5.png','',1,1508558435,1508570715,NULL,0,'adfasdf',1,'',0.00,0.00,0.00,0.00),(18,NULL,'adf ','asdgasdg245','asdgasg',2,'','',0,0,NULL,'/upload/shop/20171021/be0f558b92a7b034bc80cc267145378f.png','/upload/shop/20171021/f5859bb112bf3c37211f43058cb8f910.png','',1,1508558455,1510024250,'',0,'adfasdf',1,'',0.00,0.00,0.00,0.00),(19,NULL,'asdgasdg','','',1,'fsdg','',0,0,NULL,'/upload/shop/20171106/079815d96befd0dd406f59ab1519d44c.png','/upload/shop/20171106/e1a762f7d62b8b94d0d452e6eeced0cb.png','',1,1509937749,1510024258,'暂无描述',0,'adsg',0,'',0.00,0.00,0.00,0.00);
/*!40000 ALTER TABLE `shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_address`
--

DROP TABLE IF EXISTS `shop_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '商家id',
  `name_` varchar(100) NOT NULL COMMENT '门店名称',
  `truename_` varchar(100) DEFAULT '' COMMENT '联系人姓名',
  `mobile_` char(50) DEFAULT '' COMMENT '联系人手机',
  `address_` varchar(200) DEFAULT '' COMMENT '详细地址',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0删除',
  `zuoji` varchar(255) NOT NULL DEFAULT '' COMMENT '座机',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商户门店地址';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_address`
--

LOCK TABLES `shop_address` WRITE;
/*!40000 ALTER TABLE `shop_address` DISABLE KEYS */;
INSERT INTO `shop_address` VALUES (2,18,'88888888888','8888888888','888888888','8888888888888888888',1508570698,1508570698,1,''),(3,17,'7777777','77777777777','777777','777777777777',1508570715,1508570715,0,''),(4,17,'7777777','77777777777','777777','777777777777',1508570715,1508570715,0,''),(5,17,'7777777','77777777777','777777','777777777777',1508570897,1508570897,0,''),(6,17,'7777777','77777777777','777777','777777777777',1508570897,1508570897,0,''),(7,17,'7777777','77777777777','777777','777777777777',1508570897,1508570897,0,''),(8,17,'7777777','77777777777','777777','777777777777',1508571375,1508571375,1,''),(9,17,'7777777','77777777777','777777','777777777777',1508571375,1508571375,1,'');
/*!40000 ALTER TABLE `shop_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_confirm`
--

DROP TABLE IF EXISTS `shop_confirm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_ids` varchar(255) NOT NULL COMMENT '申请经营类目',
  `brand` varchar(255) DEFAULT '' COMMENT '经营品牌',
  `truename` varchar(20) NOT NULL,
  `phone` char(11) NOT NULL DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `st` tinyint(4) DEFAULT '0' COMMENT '0审核中，1通过 ,2不通过',
  `admin_id` int(11) NOT NULL DEFAULT '1' COMMENT 'admin_id',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='申请店铺';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_confirm`
--

LOCK TABLES `shop_confirm` WRITE;
/*!40000 ALTER TABLE `shop_confirm` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_confirm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tuangou`
--

DROP TABLE IF EXISTS `tuangou`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tuangou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '参加团购的商户',
  `good_id` int(11) NOT NULL COMMENT '参加团购的商品',
  `pnum` int(11) DEFAULT '0' COMMENT '参团人数至少',
  `store` int(11) NOT NULL COMMENT '限定团购数量（类型为2时要添加）',
  `price_group` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '团购价格',
  `deposit` decimal(10,2) DEFAULT '0.00' COMMENT '要交订金（类型为1时）',
  `end_time` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `st` tinyint(4) DEFAULT '1' COMMENT '0删除 1正在进行  2下架 ',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1限人团购（要交订金） 2限时限量',
  `attend_pnum` int(11) NOT NULL DEFAULT '0' COMMENT '目前团购参与人数',
  `already_sales` int(11) NOT NULL DEFAULT '0' COMMENT '目前已经售出的数量',
  `group_st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正在进行  2活动成功  3活动失败',
  `article_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否添加了总结   1为加总结   0为没加',
  `description` varchar(255) NOT NULL COMMENT '团购活动描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='团购商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tuangou`
--

LOCK TABLES `tuangou` WRITE;
/*!40000 ALTER TABLE `tuangou` DISABLE KEYS */;
/*!40000 ALTER TABLE `tuangou` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信用户的',
  `nickname` varchar(50) NOT NULL DEFAULT '微信昵称',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` char(11) NOT NULL DEFAULT '',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为男',
  `vistar` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `st` tinyint(4) NOT NULL DEFAULT '1',
  `addr` varchar(200) DEFAULT NULL COMMENT '所在地',
  `info` text COMMENT '个人说明',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `open_id` (`open_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='小程序会员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'adfa2342adsg','zyg-php','dufj_8d','13566985514',1,'',NULL,1,NULL,NULL,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '申请商户id',
  `cash` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '申请提现金额\n\n',
  `st` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2通过 3未通过',
  `cash_st` tinyint(4) NOT NULL DEFAULT '0' COMMENT '资金状态：0待转账 1转账成功 2转账失败 ',
  `create_time` int(11) DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商户申请提现表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES (1,3,0.23,1,0,1508909610,1508909610);
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-08  8:56:57
