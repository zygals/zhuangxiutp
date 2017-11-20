ALTER TABLE `zhuangxiu`.`withdraw` 
CHANGE COLUMN `cach` `cash` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '申请提现金额' AFTER `admin_id`;


ALTER TABLE `zhuangxiu`.`withdraw` 
MODIFY COLUMN `cash_st` tinyint(4) NOT NULL DEFAULT 1 COMMENT '资金状态：0待转账 1转账成功 2转账失败 ' AFTER `st`;

ALTER TABLE `zhuangxiu`.`withdraw` 
MODIFY COLUMN `cash_st` tinyint(4) NOT NULL DEFAULT 0 COMMENT '资金状态：0待转账 1转账成功 2转账失败 ' AFTER `st`;

ALTER TABLE `zhuangxiu`.`collect` 
CHANGE COLUMN `good_id` `collect_id` int(11) NOT NULL AFTER `user_id`;

ALTER TABLE `zhuangxiu`.`collect` 
ADD COLUMN `type` tinyint(4) NOT NULL COMMENT '1收藏商品id 2收藏店铺id' AFTER `update_time`;

ALTER TABLE `zhuangxiu`.`address` 
ADD COLUMN `st` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0删除 1正常' AFTER `update_time`;

ALTER TABLE `zhuangxiu`.`good` 
ADD COLUMN `unit` varchar(30) NOT NULL COMMENT '计量单位' AFTER `to_top`;

---------------------------------------------------------------------------------------------------------------------------------------------------------------------

ALTER TABLE `zhuangxiu`.`address` 
MODIFY COLUMN `is_default` tinyint(4) DEFAULT 1 COMMENT '是否为默认地址' AFTER `mobile`;

ALTER TABLE `zhuangxiu`.`address` 
MODIFY COLUMN `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1为默认收货地址 0为其他' AFTER `mobile`;


---------------------------------------------------------
ALTER TABLE `zhuangxiu`.`tuangou` 
ADD COLUMN `attend_pnum` int(11) NOT NULL DEFAULT 0 COMMENT '目前团购参与人数' AFTER `type`;

ALTER TABLE `zhuangxiu`.`tuangou` 
ADD COLUMN `already_sales` int(11) NOT NULL DEFAULT 0 COMMENT '目前已经售出的数量' AFTER `attend_pnum`;



2017年10月30日 10:36:51

ALTER TABLE `zhuangxiu`.`tuangou` 
ADD COLUMN `description` varchar(255) NOT NULL COMMENT '团购活动描述' AFTER `already_sales`;


2017年11月1日 15:04:19
ALTER TABLE `tuangou`
ADD COLUMN `group_st`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '1正在进行  2活动成功  3活动失败' AFTER `description`;


ALTER TABLE `tuangou`
MODIFY COLUMN `st`  tinyint(4) NULL DEFAULT 1 COMMENT '0删除 1正在进行  2下架 ' AFTER `update_time`;


2017年11月2日 09:25:04
ALTER TABLE `setting`
ADD COLUMN `img`  varchar(255) NOT NULL COMMENT '平台设置列表图片' AFTER `update_time`;

ALTER TABLE `setting`
ADD COLUMN `telephone`  varchar(10) NULL COMMENT '座机号码' AFTER `img`;


ALTER TABLE `article`
MODIFY COLUMN `type`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '1为百科 2为验房 3为团购活动' AFTER `update_time`;

ALTER TABLE `article`
ADD COLUMN `tuangou_id`  int(11) NULL COMMENT '团购活动总结' AFTER `baoming_id`;

ALTER TABLE `tuangou`
ADD COLUMN `article_st`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否添加了总结   1为加总结   0为没加' AFTER `group_st`;

ALTER TABLE `fankui`
ADD COLUMN `star`  tinyint(4) NULL DEFAULT 1 COMMENT '1  好评   2中评  3差评' AFTER `update_time`;

二〇一七年十一月九日 15:32:34
ALTER TABLE `shop`
ADD COLUMN `qrcode`  varchar(255) NULL COMMENT '二维码';


//二〇一七年十一月十六日 16:34:02
CREATE TABLE `message` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) NOT NULL ,
`shop_id`  int(11) NOT NULL ,
`message`  varchar(255) NOT NULL ,
`send_time`  int(11) NOT NULL ,
`read_time`  int(11) NULL ,
`status`  tinyint(4) NOT NULL COMMENT '留言状态  0删除 1未读 2已读' ,
`type`  tinyint(4) NOT NULL COMMENT '类型  1用户发  2商户发' ,
PRIMARY KEY (`id`)
)
;

ALTER TABLE `message`
ADD COLUMN `update_time`  int(11) NOT NULL AFTER `type`;

ALTER TABLE `message`
CHANGE COLUMN `send_time` `create_time`  int(11) NOT NULL AFTER `message`,
ADD COLUMN `update_time`  int(11) NOT NULL AFTER `type`;

ALTER TABLE `message`
MODIFY COLUMN `status`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '留言状态  0删除 1未读 2已读' AFTER `read_time`;

ALTER TABLE `message`
MODIFY COLUMN `status`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '留言状态  0删除 1未读 2已读' AFTER `read_time`,
ADD COLUMN `pid`  int(11) NOT NULL DEFAULT 0 COMMENT '父id  0为第一条信息' AFTER `update_time`;


ALTER TABLE `ts_order`
MODIFY COLUMN `preset_time`  varchar(100) NOT NULL COMMENT '预约时间';

















