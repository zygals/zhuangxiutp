alter table article drop sort;
alter table good drop sort;
alter table good drop index_show;
alter table good add to_top tinyint default 0 comment '1置顶 0不置顶';

alter table shop drop sort;
alter table shop add to_top tinyint default 0 comment '1置顶 0不置顶';
update shop set ordernum=0;
update shop set tradenum=0;
alter table shop modify ordernum int not null default 0 comment '订单量';
alter table shop modify tradenum int not null default 0 comment '交易量';

update dingdan set shop_id=10;

alter table order_good add shop_id int not null after num;
alter table order_good add price decimal(10,2) default '0.00' after num;
alter table order_good add name int not null after num;
alter table order_good add img int not null after num;
alter table order_good add st tinyint not null default 1 after num;
