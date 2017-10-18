
alter table menu_admin add is_show_to_shop tinyint not null default 1 comment '1展示 0不展示'; 
 alter table order_good change nums num int not null default 1;
alter table dingdan add shop_id int after id;
alter table user drop login_ip;
alter table user drop login_time;
alter table address change true_name truename varchar(50) not null;
alter table dingdan change good_st goodst tinyint not null default 1;
alter table fankui add shop_id int after order_id;

insert into dingdan (shop_id,orderno,user_id,address_id,sum_price,st,goodst) values (13,'asdf2463132',1,1,32.3,1,1);
insert into user (open_id,nickname,username,mobile,sex) values ('adfa2342adsg','zyg-php','dufj_8d',13566985514,1);
insert into address (user_id,truename,mobile,pcd,info) values ('1','李芯在',13566988888,'广东省广州市天河区','纟弛小区4号3层');

insert into order_good (order_id,good_id,num) values (1,11,2);


insert into order_good (order_id,good_id,num) values (1,12,3);

insert into fankui (order_id,user_id,cont) values (1,1,'goodgood!...');

update fankui set shop_id=13 where id=1;
