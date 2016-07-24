
/*1.数学函数*/
-- 绝对值函数
select abs(2),abs(-3.3),abs(-33);  -- 2 3.3 33

-- 圆周率函数
select pi();  -- 3.141593

-- 平方根函数
select sqrt(4); -- 2
select sqrt(-40); -- null

-- 求余函数
select mod(9,2); -- 1
select mod(45.5,6);  -- 3.5

-- 不小于x的最小整数ceil(x),ceiling(x)
select ceil(-3.34),ceiling(3.5);  -- -3, 4
-- 不大于x的最大整数
select floor(3.35);  -- 3

-- 产生随机0~1中的值
select rand();  -- 0.3140092336703178
select rand(10); -- 0.6570515219653505
select rand(10); -- 0.6570515219653505  rand的种子x相同则产生的随机数也相同。

-- 四舍五入函数round(x)
select round(-1.23);  -- -1
select round(-1.56);  -- -2
select round(1.23);   -- 1
select round(1.56);   -- 2

-- 四舍五入函数round(x,y),四舍五入x，保留小数点后y位，若y为负数则保留小数点左边y位
select round(-1.23,1);  -- -1.2
select round(19.56,-1);  -- 20
select round(19.56,0);   -- 20
select round(159.45,-2);  -- 200

-- truncate(x,y)直接截去小数点后y位，若y为负数，则截去小数点左边的数并用0代替（不做四舍五入）
select truncate(1.31,1); -- 1.3
select truncate(1.56,1); -- 1.5
select truncate(13.34,-1); -- 10

-- 符号函数sign（x）
select sign(-3); -- -1
select sign(0);  -- 0
select sign(4);  -- 1

-- 幂运算函数power(),pow()
select pow(2,2);	-- 4
select pow(2,-2);	-- 0.25
select power(2,2);	-- 4
select power(2,-2);  -- 0.25

-- 幂运算函数exp(x)返回e的x乘方后的值
select exp(3);  -- 20.085536923187668
select exp(0);  -- 1

-- 对数运算函数log(x)返回x相对于e的基数
select log(3);  -- 1.0986122886681098

-- 对数运算函数log10(x)返回x相对于10的基数
select log10(100);	-- 2


-- 角度与弧度相互转化的函数radians(x)将x由角度转化为弧度
select radians(180);  -- 3.141592653589793

-- 角度与弧度相互转化的函数degrees(x)将弧度转化为角度
select degrees(PI());  -- 180

-- 正弦函数sin(x)和反正弦函数asin(x),若x不在-1到1之间则返回null
select sin(PI()/6);  -- 0.49999999999999994
select asin(-1);	-- -1.5707963267948966

-- 余弦函数cos(x)和反余弦函数acos(x),若x不在-1到1之间则返回null
select cos(0);  -- 1
select cos(PI());	-- -1

-- 正切函数tan(x)和反正切函数atan(x)和余切函数cot(x)
select tan(0.3);	-- 0.3093362496096232
select atan(0.3093362496096232);	-- 0.3
select cot(PI()/4);	-- 1.0000000000000002




/*2.字符串函数*/

-- 计算字符串字符数的函数char_length(str)
select char_length('date');	-- 4
select char_length('我');	-- 1
select char_length('1');   -- 1
-- 计算字符串长度的函数length(str);
select length('date');	-- 4
select length('我');		-- 3
select length('1');  	-- 1
-- 合并字符串函数concat(s1,s2...),若其中有字符串为null则合并后为null
select concat('MySQL','5.6');	-- MySQL5.6
-- 合并字符串函数concat_ws(x,s1,s2....)使用x连接符合并字符串，若其中有字符串为null则合并后为null
select concat_ws('-','2016','07','19');	-- 2016-07-19
-- 字符串替换函数insert(s1,x,len,s2)指将s1字符串从x位开始的len长度用字符串s2替换，若x超出s1的范围则返回原字符串s1
select insert('quest',2,4,'what');	-- qwhat
select insert('quest',-1,4,'what');  -- quest
select insert('quest',2,100,'what');	-- qwhat
-- 大小写字母的转换
select lower('LOWER');	-- lower
select lcase('LCASE');  -- lcase
select upper('upper');	-- UPPER
select ucase('ucase');	-- UCASE
-- 获取指定长度的字符串
select left('hello world',5);	-- hello
select right('hello world',5);  -- world
-- 填充字符串函数lpad(s1,len,s2)和rpad(s1,len,s2)使用s2填充s1,成为len长度的字符串，若s1的长度大于len则截取len长度
select lpad('hello',4,'??');	-- hell
select lpad('hello',10,'??');	-- ?????hello
select rpad('hello',10,'?');	-- hello?????
-- 删除空格的函数
select ltrim(' hello ');  -- hello 
select rtrim(' hello ');  -- hello
select trim(' hello ');	-- hello
-- 删除指定字符串左右两边的子字符串
select trim('h' from 'helloh');	-- ello
-- 重复生成字符串的函数repeat(s,n)生成n个s
select repeat('h',3);  -- hhh
select repeat('h',-1);  -- 空字符串
-- 空格函数space(n)生成n个空格
select space(4);  -- 生成4个空格的字符串
-- 替换函数replace(s,s1,s2)使用s2代替字符串s中的所有子字符串s2
select replace('xxx.baidu.com','x','w');  -- www.baidu.com
-- 比较字符串大小的函数strcmp(s1,s2),若相等则返回0，若s1小于s2则-1，否则1
select strcmp('text','text2');	-- -1
select strcmp('text','text'); -- 0
select strcmp('text2','text');  -- 1
-- 获取子字符串函数substring(s1,n,len),从字符串的n位（起始位为1）开始截取len长度，若n为小于1则返回空字符串
select substring('breakfast',5);	-- kfast
select substring('lunch',2,3);	-- unc
select substring('lunch',-5,3);	-- lun
select substring('lunch',-5);	-- lunch
select mid('breakfast',5);	-- kfast
-- 匹配字串开始的位置locate(str1,str),position(str1 in str),insrt(str,str1)
select locate('ball','football');	-- 5
select position('ball' in 'football');  -- 5
select instr('football','ball');  	-- 5
-- 字符串逆序的函数
select reverse('abc');	-- cba
-- 返回指定位置的字符串
select elt(3,'a','b','c');	-- c
select elt(4,'a','b','c');	-- null
-- 返回指定字符串位置的函数，field(s,s1,s2,s3....),返回s在s1,s2...中的位置
select field('a','b','c','d','a');	-- 4
-- 返回子字符串位置的函数
select find_in_set('a','c,d,a,a');	-- 3
-- 选取字符串的函数
select make_set(1,'a','b','c','d');	-- a
select make_set(1|4,'a','b','c');	-- a,c 二进制1或4为0101，选取第1个和最后一个
select make_set(1|4,'a','b','c','d');	-- a,c 二进制1或4为0101，选取第1个和最后一个








