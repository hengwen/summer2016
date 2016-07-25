show processlist;
use company;
/*创建索引*/


## 创建普通索引
create table book(
		bookid int null,
        bookname varchar(255) not null,
        authors varchar(255) not null,
        info varchar(255) not null,
        comment varchar(255) not null,
        year_publication year not null,
        index(year_publication)
);
## 使用explain查看索引是否正在使用
explain select * from book where year_publication=1990;


## 创建唯一索引
create table t1(
	id int not null,
    name varchar(50) not null,
    unique index(id)
);
show create table t1;

## 创建单列索引，并且定义索引名称，以及索引长度
create table t2(
	id int not null,
    name varchar(50) not null,
    index SingleIndex(name(20))
);

## 创建组合索引
create table t3(
	id int not null,
    name varchar(50) not null,
    age tinyint not null,
    info varchar(255) not null,
    index MultiIndex(id,name,age)
);
explain select * from t3 where id=1 and name = 'jason';
explain select * from t3 where name = 'jason';

## 创建全文索引（MYISAM存储引擎支持）
create table t4(
	id int not null,
    name varchar(50),
    age tinyint not null,
    info varchar(255),
    fulltext index FulltextIndex(info)
)engine = MyISAM;

create table t5(
	g geometry not null,
    spatial index spatInd(g)
)engine = MyISAM default charset=utf8;


## 在已经存在的表中创建索引
show index from book;  -- 查看当前表索引，
## 使用alter table tablename add
alter table book add index bkName(bookname(30));
## 使用create index
create index bkAuthor on book(authors);

## 删除索引
alter table book drop index bkName;
drop index bkAuthor on book;




