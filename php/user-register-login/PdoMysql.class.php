<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/11
 * Time: 上午10:46
 */
class PdoMysql
{
    //静态属性会被所有实例共享
    public static $config = array();  //连接数据库属性
    public static $link = null; //连接数据库标志,也是使用单例模式判断依据
    public static $pconnect = false;  //是否开启长连接标志
    public static $dbVersion = null;  //数据库版本信息
    public static $dbConnect = false; //是否连接成功标志
    public static $PDOStatement = null; //查询结果集
    public static $queryStr = '';  //当前执行的sql语句
    public static $error = '';  //错误信息
    public static $affectRowNum = 0;  //所影响的记录条数
    public static $lastInsertId = null; //最后一条sql语句插入的auto_increment值
    /**
     * 连接数据库
     * PdoMysql constructor.
     * @array string $dbconfig
     */
    public function __construct($dbconfig='')
    {
        //判断是否开启PDO
        if (!class_exists('PDO')) {
            self::throwException("不支持PDO,请先开启");
        }
        if (!$dbconfig) {
            $dbconfig = array (
                'hostname' => DB_HOST,
                'username' => DB_USER,
                'password' => DB_PWD,
                'dbname'   => DB_NAME,
                'dbport'   => DB_PORT,
                'dbtype'   => DB_TYPE,
                'dsn'      => DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME
            );
        }
        if (!isset($dbconfig['hostname'])) {
            self::throwException("没有设置连接数据库配置信息");
        }
        self::$config = $dbconfig;
        //在连接属性中添加一个配置选项options
        if (empty(self::$config['options'])) self::$config['options'] = array();
        //单例模式:如果已经设置则不再实例化新对象,否则实例化
        if (!isset(self::$link)) {
            $configs = self::$config;
            if (self::$pconnect) {
                //开启长连接
                $configs['options'][constant("PDO::ATTR_PERSISTENT")] = true;
             }
            //连接数据库
            try{
                self::$link = new PDO($configs['dsn'],$configs['username'],$configs['password'],$configs['options']);
            } catch (PDOException $e) {
                self::throwException($e->getMessage());
            }
            if(!self::$link) {
                self::throwException("数据库连接失败");
                return false;
            }
            //设置字符编码
            self::$link->exec('SET NAMES '.DB_CHARSET);
            //获取数据库版本
            self::$dbVersion = self::$link->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
            self::$dbConnect = true;
            unset($configs);
        }
    }


    /**
     * 提示错误信息
     * @string $errMsg
     */
   public static function throwException($errMsg)
   {
       echo "<div style='width: 80%;background:#ABCDEF;color:black;font-size:20px;padding:20px 0px;'>$errMsg</div>";
   }

    /**
     * 获取结果集中所有数据
     * @string null $sql
     * @return mixed
     */
    public static function fetchAll($sql=null)
    {
        if (null != $sql) {
            self::query($sql);
        }
        $result = self::$PDOStatement->fetchAll(constant("PDO::FETCH_ASSOC"));
        return $result;
    }

    /**
     * 获取一条结果集记录
     * @string null $sql
     * @return mixed
     */
    public static function getRow($sql = '')
    {
        if (null != $sql) {
            self::query($sql);
        }
        $result = self::$PDOStatement->fetch(constant("PDO::FETCH_ASSOC"));
        return $result;
    }

    /**
     * 普通的查找
     * @param $tables
     * @param null $where
     * @param string $fields
     * @param null $group
     * @param null $having
     * @param null $order
     * @param null $limit
     */
    public static function find($tables,$where=null,$fields='*',$group=null,$having=null,$order=null,$limit=null)
    {
        $sql = "select ".self::parseFields($fields)." from ".$tables
            .self::parseWhere($where)
            .self::parseGroup($group)
            .self::parseHaving($having)
            .self::parseOrder($order)
            .self::parseLimit($limit);
        $result = self::fetchAll($sql);
        //如果只有一条记录则返回以为数组
        $num = count($result);
        if ($num == 1) {
            $res = $result[0];
        } elseif ($num > 1) {
            $res = $result;
        } else {
            $res = false;
        }
        return $res;
//        return (count($result) > 1) ? $result : $result[0];
    }
    /**
     * 执行sql语句
     * @param string $sql
     * @return bool
     */
    public static function query($sql='')
    {
        $link = self::$link;
        if (!$link) return false;
        if (!empty(self::$PDOStatement)) self::free();
        self::$queryStr = $sql;  //当前执行的sql语句
        self::$PDOStatement = $link->prepare($sql);
        $result = self::$PDOStatement->execute();
        self::haveErrorThrowException();

        return $result;
    }

    /**
     * 添加操作
     * @array $data
     * @string $table
     * @return mixed
     */
    public static function add($data,$table)
    {
        $keys = array_keys($data);
        array_walk($keys,array('PdoMysql','addSpecialChar'));
        $fieldsStr = implode(',',$keys);
        $values = "'".join("','",array_values($data))."'";
        $sql = "insert into ".$table."(".$fieldsStr.") values(".$values.")";
        return self::execute($sql);
    }

    /**
     * 删除操作
     * @string $table
     * @string  $where
     * @param null $order
     * @param int $limit
     * @return bool|int
     */
    public static function delete($table,$where=null,$order=null,$limit=0)
    {
        $sql = "delete from ".$table.self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
        return self::execute($sql);
    }

    /**
     * 更新操作
     * @string $table
     * @param $data
     * @param null $where
     * @param null $order
     * @param int $limit
     * @return bool|int
     */
    public static function update($table,$data,$where=null,$order=null,$limit=0)
    {
        $sets = '';
        foreach ($data as $key=>$value) {
            $sets .= $key."='".$value."',";
        }
        $sets = rtrim($sets,',');
        $sql = "update ".$table." set ".$sets.self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
        return self::execute($sql);
    }

    /**
     * 执行增删改操作,返回受影响的记录条数
     * @param null $sql
     * @return bool|int
     */
    public static function execute($sql=null)
    {
        $link = self::$link;
        if (!$link) return false;
        self::$queryStr = $sql;
        if (!empty(self::$PDOStatement)) self::free();
        $result = $link->exec($sql);  //返回影响的记录条数
        self::haveErrorThrowException();
        if ($result) {
            self::$affectRowNum = $result;
            self::$lastInsertId = $link->lastInsertId();
            return self::$affectRowNum;
        } else {
            return false;
        }
    }

    /**
     * 根据主键id查找一条记录
     * @sting $table
     * @int $id
     * @param string $fields
     * @return mixed
     */
    public static function findById($table,$id,$fields='*')
    {
        $sql = "select %s from %s where id = %d";
        return self::getRow(sprintf($sql,self::parseFields($fields),$table,$id));
    }

    /**
     * 获得最后执行的sql语句
     * @return bool|string
     */
    public static function getLastSql()
    {
        $link = self::$link;
        if (!$link) return false;
//        return self::$queryStr;
        return self::$queryStr;
    }

    /**
     * 获得最后插入语句的insertid值
     * @return bool|null
     */
    public static function getLastInsertId()
    {
        $link = self::$link;
        if (!$link) return false;
        return self::$lastInsertId;
    }

    /**
     * 获取数据库版本
     * @return bool|mixed|null
     */
    public static function getDbVersion()
    {
        $link = self::$link;
        if (!$link) return false;
        return self::$dbVersion;
    }
    /*
     * 获取数据库中的所有表
     */
    public static function getTables()
    {
        $tables = array();
        self::query("show tables");
        $result = self::fetchAll();
        foreach ($result as $key=>$val) {
            $tables[$key] = current($val);  //current输出数组当前指针指向的元素的值
        }
        return $tables;
    }

    /**
     *解析字段,(构造`username`,`password`形式)
     * @param $fields
     * @return array|string
     */
    public static function parseFields($fields)
    {
        if (is_array($fields)) {
//            $fields = '`'.implode('`,`',$fields).'`';
            array_walk($fields,array('PdoMysql','addSpecialChar')); //使用用户自定的函数对数组中的每个元素做回调处理
            $fieldsStr = implode(',',$fields);
        } elseif (is_string($fields) && !empty($fields)) {
            if (strpos($fields,'`') === false) {
                $fields = explode(',',$fields);
                array_walk($fields,array('PdoMysql','addSpecialChar'));
                $fieldsStr = implode(',',$fields);
            } else {
                $fieldsStr = $fields;
            }
        } else {
            $fieldsStr = '*';
        }
        return $fieldsStr;
    }

    /**
     * 解析where
     * @string $where
     * @return string
     */
    public static function parseWhere($where)
    {
        $whereStr = '';
        if (is_string($where) && !empty($where)) {
            $whereStr = $where;
        }
        return empty($whereStr) ? '' : ' where '.$whereStr.' ';
    }

    /**
     * 解析group
     * @param $group
     * @return string
     */
    public static function parseGroup($group)
    {
        $groupStr = '';
        if (is_array($group)) {
            $groupStr = ' group by '.implode(',',$group).' ';
        } elseif (is_string($group) && !empty($group)) {
            $groupStr = ' group by '.$group.' ';
        }
        return $groupStr;
    }

    /**
     * 解析having
     * @string $having
     * @return string
     */
    public static function parseHaving($having)
    {
        $havingStr = '';
        if (is_string($having) && !empty($having)) {
            $havingStr = ' having '.$having.' ';
        }
        return $havingStr;
    }

    /**
     * 解析order
     * @param $order
     * @return string
     */
    public static function parseOrder($order)
    {
        $orderStr = '';
        if (is_array($order)) {
            $orderStr = ' order by '.implode(',',$order);
        } elseif (is_string($order) && !empty($order)) {
            $orderStr = ' order by '.$order;
        }
        return $orderStr;
    }

    /**
     * 解析limit,limit 4,5或者limit 3的形式
     * @param $limit
     * @return string
     */
    public static function parseLimit($limit)
    {
        $limitStr = '';
        if (is_array($limit)) {
            if (count($limit) > 1) {
                $limitStr = " limit $limit[0],$limit[1]";
            } else {
                $limitStr = " limit $limit[0]";
            }
        } elseif (is_string($limit) && !empty($limit)) {
            $limitStr = " limit ".$limit;
        }
        return $limitStr;
    }

    /**
     * 添加反引号
     * @string $value
     * @return string
     */
    public static function addSpecialChar(&$value)
    {
        if ($value==='*'||strpos($value,'.')!==false||strpos($value,'`')!==false) {
            //不需要处理
        } elseif (strpos($value,'`') === false) {  //必须使用===全等符号,因为第一个下标为0会转换为false
            $value = '`'.trim($value).'`';  //去除元素的左右空格,再两边添加反引号
        }
        return $value;
    }

    /**
     * 执行sql语句错误提示
     * @return bool
     */
    public static function haveErrorThrowException()
    {
        $obj = empty(self::$PDOStatement) ? self::$link :self::$PDOStatement;
        $errorArr = $obj->errorInfo();
        //如果有错误则提示
        if ($errorArr[0] != '00000') {  //00000表示没有错误
            self::$error = 'SQLSTATE:'.$errorArr[0]."<br>"."SQL Error:".$errorArr[2]."<br>Error SQL:".self::$queryStr;
            self::throwException(self::$error);
            return false;
        }
        //如果执行语句为空则报错
        if (self::$queryStr == '') {
            self::throwException("没有执行的sql语句");
            return false;
        }
    }

    /**
     * 释放查询结果集
     */
    public static function free()
    {
        self::$PDOStatement = null;
    }

}
