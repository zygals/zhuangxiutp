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
