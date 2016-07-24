/*时间和日期函数*/

## 获取系统当前日期函数
select curdate(),current_date(),curdate()+0;  -- 2016-07-20, 2016-07-20, 20160720
## 获取系统当前时间函数
select curtime(),current_time(),curtime()+0;	-- 14:51:28, 14:51:28, 145128.000000
## 获取当前系统日期和时间函数
select current_timestamp(),now(),localtime(),sysdate();	-- 2016-07-20 14:53:36(相同）
## UNIX时间戳函数
select unix_timestamp(),unix_timestamp(now()),now();	-- 1468997880 1468997880 2016-07-20 14:58:00
select from_unixtime('1468997880');		-- 2016-07-20 14:58:00将unix时间戳转换为普通格式
## 返回UTC（世界标准时间）的日期和时间函数
select utc_date(),utc_date()+0;		-- 2016-07-20, 20160720
select utc_time(),utc_time()+0;		-- 07:02:30, 70230.000000
## 获取指定日期中的月份值和月份名
select month('2016-07-20');		-- 7
select monthname('2016-07-20');		-- July
## 获取星期的函数
select dayname('2016-07-20');	-- Wednesday
select dayofweek('2016-07-20');	-- 4 (1表示周日，2表示周一）
select weekday('2016-07-20');	-- 2 (0表示周一）
## 获取指定日期是一年中的第几周
select week('2011-02-20');		-- 8 (默认mode=0，一周的第一天为周日）
select week('2011-02-20',0);	-- 8
select week('2011-02-20',1);	-- 7 （一周的第一天为周一）
## 计算m某天位于一年中的第几周
select week('2011-02-20',3);	-- 7
select weekofyear('2011-02-20');	-- 7
## 返回日期是一年中的第几天
select dayofyear('2016-07-20');		-- 202
## 返回日期是当月的第几天
select dayofmonth('2016-07-20');	-- 20
## 获取年份，季度，小时，分钟，秒
select year(curdate());		-- 2016
select quarter(current_date());	-- 3
select hour(now());		-- 15
select minute(curtime());	-- 27
select second(current_time());	-- 20

## 获取日期的指定值
select extract(year from now());	-- 2016
select extract(year_month from now());	-- 201607
## 时间和秒钟的转换
select time_to_sec('15:31:00');	-- 55860
select sec_to_time(55860);	-- 15:31:00
## 计算时间和日期的函数
select now();
select date_add(now(),interval 1 second),adddate(now(),interval 1 second);
select date_add(now(),interval '1:1' minute_second);
## 减法同理
## 计算两个日期的间隔天数
select datediff('2016-07-20','2016-06-30');	-- 20
## 格式化时间函数
select date_format('2016-07-20 15:42:16','%H,%i,%s');	-- 15,42,16
select date_format('2016-07-20 15:42:16','%Y*%m*%d,%H,%i,%s');	-- 2016*07*20,15,42,16

/*条件判断函数*/
select if(1>2,2,3);  -- 3
select ifnull(null,1);  -- 1
select ifnull(9,1);  -- 9
select isnull(null);  -- 1

/*系统信息函数*/
## 获取MySQl版本
select version();	-- 5.5.42
## 查看当前用户的连接数
select connection_id();		-- 310
## 当前用户的连接信息
show processlist;
use shopImooc;
## 显示当前数据库
select database(),schema();	-- shopimooc,shopimooc
## 显示当前用户
select user(),current_user(),system_user();	-- root@localhost,root@localhost,root@localhost
## 获取字符串的字符集
select charset('abc');	-- utf8
select charset(convert('abc' using latin1));	-- latin1
## 获取字符串的排序方式
select collation('abc');	-- utf8_general_ci
## 获取最后一个自动生成的ID值的函数
-- 一次插入一条数据
use company;
create table worker(
	id int auto_increment not null primary key,
    name varchar(20) not null);
insert into worker values(null,'jason');
select last_insert_id();	-- 1
insert into worker values(null,'jason1');
select last_insert_id();	-- 2
-- 一次插入多条数据是
insert into worker values(null,'jason2'),(null,'jason3'),(null,'jason4');
select * from worker;
select last_insert_id();	-- 3(而不是5）


/*加密函数*/
select password('hengwen');	-- *083412D83C78EB8829324221C208BCA36A7DEBA1
select md5('hengwen');	-- a68e4cd1d7aef80d7db37f7735ac230d
select encode('secret','cry');  -- 加密为乱码
select decode(encode('secret','cry'),'cry'); 

/*其他函数*/
## 格式化函数
select format('12.4559',2);	-- 12.46
## 进制转化
select conv('a',16,2); -- 1010(将16进制的a转化为二进制
## 将IP地址转化为数字
select inet_aton('209.207.02.02');	-- 3520004610(计算方法：209*256^3+207*256^2+2*256+2)
select inet_ntoa('3520004610');		-- 209.207.02.02
## 加锁函数和解锁函数get_lock(str,time),str为锁名，time为加锁时间。
select get_lock('lock1',10),is_free_lock('lock1'),is_used_lock('lock1'),release_lock('lock1'); -- 1 ，0 ， 310（connect id), 1
## 重复执行指定操作的函数
select benchmark(500000,password('hengwen'));
## 改变字符子的函数
select charset('string'),charset(convert('string' using latin1));  -- utf8  latin1















