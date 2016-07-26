show processlist;
show databases;

use mysql;
show tables;

desc user;

## 使用create user创建新用户
create user 'jason'@'localhost' identified by '123456'; -- 若主机名为‘%’则表示对所有主机开放权限
select * from user where User='jason2';

## 避免使用明文指定用户密码 
select password('123456');
create user 'jason1'@'localhost' identified by password '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9';

## 使用grant创建用户Jason2，并授予对所有数据库表的select和update权限
grant select,update on *.* to 'jason2'@'localhost' identified by '123456';


## 使用insert into向user表插入数据
insert into user(Host,User,Password) values('localhost','jason3',password('123456'));

## 删除用户
drop user 'jason'@'localhost';  -- 删除用户在本地登录的权限
delete from user where host='localhost' and user='jason1';

## 修改root用户密码
mysqladmin -u root -h localhost -p password '12345';
## 修改user表
update mysql.user set Password=password('12345') where user='root' and host='localhost';
## 使用set
set password=password('123456');

select user,password from user;

## root用户修改普通用户密码
set password for 'jason3'@'localhost'=password('123456');  -- 失败
update mysql.user set password=password('123456') where user='jason3' and host='localhost';
grant usage on *.* to 'jason2'@'localhost' identified by '12345';


create database team;
use team;
create table player(
playid int primary key,
playname varchar(30) not null,
teamnum int not null unique,
info varchar(50)
);
## 创建新用户account1通过本地主机连接数据库，密码为oldpwd1
##，授权该用户对team数据库中的play表的insert、select权限，并对info字段的update权限
grant select,insert,update(info) on team.player to 'account1'@'localhost' identified by 'oldpwd1'; 
## 使用表查看权限
select * from mysql.user;
select * from mysql.tables_priv;
select * from mysql.columns_priv;
## 修改密码
grant usage on team.player to 'account1'@'localhost' identified by 'newpwd1';
update mysql.user set password=password('newpwd') where user='account1' and host='localhost';
## 查看权限
show grants for 'account1'@'localhost';
## 回收权限
revoke select,insert,update on team.player from 'account1'@'localhost';
## 删除用户
delete from mysql.user where host='localhost' and user='account1';
drop user 'account1'@'localhost';

















