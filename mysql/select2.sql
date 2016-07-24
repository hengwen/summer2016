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

## 内连接查询
select s.s_id,s_name,f_name,f_price from fruits f inner join suppliers s on f.s_id=s.s_id;  
## 外连接：左连接
insert into suppliers(s_id,s_name,s_city,s_zip,s_call) values(108,'GOOD','rizhao',null,'45423');
select s.s_id,s_name,f_name,f_price from fruits f left join suppliers s on f.s_id = s.s_id; 
## 外连接：有连接   
select s.s_id,s_name,f_name,f_price from fruits f right join suppliers s on f.s_id = s.s_id;    
## 复合条件连接查询
select s.s_id,s_name,f_name,f_price from fruits f left join suppliers s on f.s_id = s.s_id where s.s_name = 'FNK Inc';

/*子查询*/
create table tb1(num1 int not null);
create table tb2(num2 int not null);
insert into tb1 values(5),(13),(34),(89);
insert into tb2 values(42),(1),(34),(93);
## any子查询，条件满足any中的一个即可（满足内层其中一个条件即可）
select num2 from tb2 where num2 > any(select num1 from tb1);
select num2 from tb2 where num2 > some(select num1 from tb1);
## all子查询需要满足所有内层条件
select num2 from tb2 where num2 > all(select num1 from tb1);  -- 93
## exits子查询，存在则返回true，否则false
select * from tb1 where exists(select num2 from tb2 where num2 = 41);  -- 如果tb2中有41则查询tb1中的所有数据
## in子查询,满足外层的条件在内层的查询结果中
select num1 from tb1 where num1 in(select num2 from tb2);  -- 34
## 使用大于，等于等比较运算符号同理


/*合并查询结果*/
## 使用union和union all合并查询(union会删除重复的行，union则不会）
select s_id,f_name,f_price from fruits where f_price > 9.0 union select s_id,f_name,f_price from
fruits where s_id in(101,103);

select s_id,f_name,f_price from fruits where f_price < 9.0 union all select s_id,f_name,f_price from
fruits where s_id in(101,103);

/*使用正则表达式查询*/
## 以b开头的水果名称
select * from fruits where f_name regexp '^b';
## 以y结尾的水果名称
select * from fruits where f_name regexp 'y$';
## 查询a与g之间有一个字符的记录
select * from fruits where f_name regexp 'a.g';
## 以b开头，b后出现a(*表示零个或者多个）
select * from fruits where f_name regexp '^ba*';    
## 以b开头，b后出现a(+表示零个或者多个）
select * from fruits where f_name regexp '^ba+';  
## 包含on
select * from fruits where f_name regexp 'on|ap';    
select * from fruits where f_name regexp 'on';   -- 有返回
select * from fruits where f_name like 'on';  -- null 
## 匹配指定字符中的任意一个
select * from fruits where f_name regexp '[ot]';
select * from fruits where f_name regexp 'o|t';    
select * from fruits where s_id regexp '[456]';  
select * from fruits where s_id regexp '[4-6]';    
## 匹配指定字符以外的记录
select * from fruits where f_id regexp '[^a-e1-2]';    -- 有问题
## 使用{n,}或者{n,m}来指定字符串连续出现的次数
## x至少出现2次
select * from fruits where f_name regexp 'x{2,}';
## 至少一次最多三次
select * from fruits where f_name regexp 'ba{1,3}';












   





