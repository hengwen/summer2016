/*查询数据*/
use company;
CREATE TABLE IF NOT EXISTS fruits(
	f_id char(10) NOT NULL,
	s_id int not null,
	f_name char(255) not null,
    f_price decimal(10,2) not null,
    primary key(f_id)
);
insert into fruits(f_id,s_id,f_name,f_price) values
	('a1',101,'apple',5.2),
	('b1',101,'blackberry',10.2),
    ('bs1',102,'orange',11.2),
    ('bs2',104,'melon',8.2),
    ('t1',102,'banana',10.3),
    ('o2',103,'cocomut',9.2),
    ('c0',101,'cherry',3.2),
    ('a2',103,'apricot',2.2),
    ('l2',104,'lemon',6.4),
    ('b2',104,'berry',7.6),
    ('m1',106,'mango',15.6),
    ('m2',105,'xbabay',2.6),
    ('t4',107,'xbababa',3.6),
    ('m3',105,'xxtt',11.6),
    ('b5',107,'xxxx',3.6);
    
select * from fruits;

## 带in的关键字查询
select s_id,f_name,f_price from fruits where s_id in (101,102);
select s_id,f_name,f_price from fruits where s_id not in (101,102);
## 带between and的范围查找
select s_id,f_name,f_price from fruits where f_price between 5 and 7;
select s_id,f_name,f_price from fruits where f_price not between 5 and 7;
## %通配符匹配任意长度的字符，甚至包括零字符
select s_id,f_name,f_price from fruits where f_name like 'b%';
## _通配符匹配任意一个字符
select s_id,f_name,f_price from fruits where f_name like '_pp__';
## 查询空值：表示数据位置、不适用或将在以后添加
alter table fruits add text varchar(50) null;
select s_id,f_name,f_price from fruits where text is null;
select s_id,f_name,f_price from fruits where text is not null;
## 带and的查询
select s_id,f_name,f_price from fruits where s_id = 101 and f_price >= 5;
select s_id,f_name,f_price from fruits where (s_id =101 or s_id = 102) and f_price >= 5 and f_name = 'apple';
select s_id,f_name,f_price from fruits where s_id in(101,102) and f_price >= 5 and f_name = 'apple';
## 查询结果不重复
select distinct s_id from fruits;
## 查询排序
select f_name from fruits order by f_name;
select f_name from fruits order by f_name desc;
## 多列排序 
insert into fruits values('a3',102,'apple',3.0,'df');
select s_id,f_name,f_price from fruits order by f_name,f_price;
## 分组查询
## 根据s_id对fruits表中d的数据进行分组查询
select s_id,count(*) total from fruits group by s_id;
## 根据s_id对fruits表中d的数据进行分组查询,并将每个分组的成员显示出来
select s_id,group_concat(f_name) names,count(*) total from fruits group by s_id;
## 使用having 过滤,显示分组中数量大于2的组
select s_id,group_concat(f_name) names,count(f_name) total from fruits group by s_id having total > 2;
## 在group by之后使用with rollup 用于统计显示的记录数量
select s_id,count(*) as total from fruits group by s_id with rollup;
## 多字段分组
select f_id,s_id,f_name,f_price from fruits group by s_id,f_name;

## 使用limit[位置偏移量]，行数
select f_id,s_id,f_name from fruits limit 5;

## count函数
select count(*) as total from fruits;
select count(text) as total from fruits;
## sum函数
select sum(f_price) from fruits;
## avg函数
select avg(f_price) from fruits where s_id = 103;


/*连接查询*/
use company;
create table suppliers(
	s_id int not null auto_increment,
    s_name char(50) not null,
    s_city char(50) null,
    s_zip char(50) null,
    s_call char(50) not null,
    primary key(s_id)
);
insert into suppliers(s_id,s_name,s_city,s_zip,s_call)
	values(101,'FastFruit Inc.','Tianjin','300000','48075'),
	(102,'LT Supplies','Chongqing','400000','44333'),
    (103,'ACME','Shanghai','200000','90046'),
    (104,'FNK Inc','Zhongshan','528437','11111'),
    (105,'Good Set','Taiyuan','030000','22222'),
    (106,'Just Eat Ours','Beijing','010','45679'),
    (107,'Dk inc','Zhengzhou','450000','33332');
## 等同内连接查询
select fruits.s_id,s_name,f_name,f_price from fruits,suppliers where fruits.s_id = suppliers.s_id order by s_id;    
## 内连接查询
select fruits.s_id,s_name,f_name,f_price from fruits inner join suppliers on fruits.s_id = suppliers.s_id order by s_id;
    
    
    
    
    
    
    
    
    
    
    
    
    





