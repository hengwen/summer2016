## 使用rand（）生成3个10之内的整数
select round(rand()*10),floor(rand()*10);
## 使用sin(),cos(),tan(),cot()计算三角函数值
select PI(),sin(PI()/2),cos(PI()),round(tan(PI()/4)),floor(cot(PI()/4)); -- 3.141593, 1 , -1 , 1, 1 


use company;
create table member(
	m_id int auto_increment primary key,
    m_FN varchar(100),
    m_LN varchar(100),
    m_birth datetime,
    m_info varchar(255) null
);
insert into member values(null,'Halen','Park','1970-06-29','GoodMan');

select length(m_FN),concat(m_FN,m_LN),lower(m_info),reverse(m_info) from member;  -- 5, HalenPark, goodman, naMdooG

select year(curdate())-year(m_birth) as age,
dayofyear(m_birth) as days,
date_format(m_birth,'%W %D %M %Y') as birthDate  -- 46, 180, Monday 29th June 1970
from member;

insert into member values(null,'Samuel','Green',now(),null);
select last_insert_id();  -- 2

select * from member;

select year(m_birth) from member;

show variables like 'character_set_%';


/*练习题*/

select 18/5,18%5;

select degrees(PI()/4);	-- 45

select power(9,4);

select round(3.14159,2);  -- 3.14
select truncate(3.14158,2);  -- 3.14

select length('Hello World!');		-- 12
select char_length('Hello World!');	-- 12
select substring('Nice to meet you!',9,4);   -- meet
select repeat('Cheer!',3);	-- Cheer!Cheer!Cheer!
select reverse('voodoo');	-- oodoov
select make_set(5|8,'MySQL','not','is','greet');
select weekofyear(now());
select dayofyear(now());
select dayofweek(now());
select year(now())-year('1924-02-12');
select time_to_sec(time(now()));


show processlist;
select encode('mysql','cry');
select conv(100,10,16);
select format(5.1584,3);
select charset(convert('new string' using gb2312));