create database if not exists imooc default charset utf8;

use imooc;

## 父id实现无限级分类
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
    
    
    
## 全路径方式实现无限极分类   
create table if not exists category_path(
	id int(10) unsigned not null auto_increment,
    cateName varchar(30) not null,
    path varchar(50) not null,
    createTime int(10) not null,
    primary key(id)
    )engine=InnoDB default charset=utf8;
    
    
insert into category_path(id,cateName,path,createTime) 
values (1,'手机','',unix_timestamp()),
	(2,'功能手机','1',unix_timestamp()),
    (3,'老人手机','1,2',unix_timestamp()),
    (4,'儿童手机','1,2',unix_timestamp()),
    (5,'智能手机','1',unix_timestamp()),
    (6,'android手机','1,5',unix_timestamp()),
    (7,'IOS手机','1,5',unix_timestamp()),
    (8,'WinPhone手机','1,5',unix_timestamp()),
    (9,'色盲手机','1,2,4',unix_timestamp()),
    (10,'大字手机','1,2,3',unix_timestamp());
    
    
    
    
    
    
    
    
    
    
    
    