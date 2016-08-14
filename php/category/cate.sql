create database if not exists imooc default charset utf8;

use imooc;

create table if not exists category_parent(
	id int(10) unsigned not null auto_increment,
    pId int(10) unsigned not null comment "父id",
    cateName varchar(30) not null comment "分类名称",
    createTime int(10) not null comment "创建时间",
    primary key(id)
)engine=InnoDB default charset=utf8;

insert into category_parent(id,pId,cateName,createTime) 
values(1,0,'新闻',unix_timestamp()),
	(2,0,'图片',unix_timestamp()),
    (3,1,'国内新闻',unix_timestamp()),
    (4,1,'国际新闻',unix_timestamp()),
    (5,3,'北京新闻',unix_timestamp()),
    (6,4,'美国新闻',unix_timestamp()),
    (7,2,'美女图片',unix_timestamp()),
    (8,2,'风景图片',unix_timestamp()),
    (9,7,'日韩明星',unix_timestamp()),
    (10,9,'孙艺珍',unix_timestamp());