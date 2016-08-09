<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/8/9
 * Time: 上午9:33
 */
class Comment{
    private $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 提交表单验证,如果验证成功返回false并将错误信息赋值给引用变量$arr;
     * 成功则返回true,并将提交表单信息赋值给引用变量$arr;
     * @array $arr
     * @return bool
     */
    public static function validate(&$arr)
    {
        //验证昵称是否合法,使用validate_str函数过滤非法字符
        if (!($data['username'] = filter_input(INPUT_POST,'username',FILTER_CALLBACK,array('options'=>'Comment::validate_str')))) {
            $errors['username'] = "非法用户名";
        }
        //验证头像是否合法
        $options = array(  //定义头像value值得范围规则
            'options'=>array(
                'min_range' => 1,
                'max_range' => 4
            )
        );
        if (!($data['face'] = filter_input(INPUT_POST,'face',FILTER_VALIDATE_INT,$options))) {
            $errors['face'] = "非法头像";
        }
        //验证邮箱是否合法
        if (!($data['email'] = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))) {
            $errors['email'] = "非法邮箱";
        }
        //验证地址是否合法
        if (!($data['url'] = filter_input(INPUT_POST,'url',FILTER_VALIDATE_URL))) {
            $errors['url'] = "非法地址";
        }
        //验证评论是否合法
        if (!($data['content'] = filter_input(INPUT_POST,'content',FILTER_CALLBACK,array('options'=>'Comment::validate_str')))) {
            $errors['content'] = "请输入合法内容";
        }
        //如果表单存在错误则传递错误信息,返回false
        if (!empty($errors)) {
            $arr = $errors;
            return false;
        }
        //表单验证成功传递信息,返回true
        $arr = $data;
        $arr['email'] = strtolower(trim($arr['email']));
        return true;
    }

    /**
     * 过滤字符串
     * @string $str
     * @return bool|string
     */
    public static function validate_str($str)
    {
        //检查以utf-8编码的字符串长度
        if (mb_strlen($str,'utf8') < 1) {
            return false;
        }
        //使用htmlspecialchars函数将字符串中的<,>,',",&转化成html实体,
        //在字符串中的新行(遇到\n换行符)前插入html换行符(<br>)
        $str = nl2br(htmlspecialchars($str,ENT_QUOTES));
        return $str;
    }

    public function output()
    {
        if ($this->data['url']) {
            $link_start = "<a href='".$this->data['url']."' target='_blank'>";
            $link_end = "</a>";
        }
        $dataStr = date("Y年m月d日 H:i:s",$this->data['pubTime']);
        $str = <<<EOF
            <div class="comment">
                <div class="face">
                    {$link_start}
                        <img src="img/{$this->data['face']}.jpg" >
                    {$link_end}
                </div>
                <span class="username">
                    {$link_start}{$this->data['username']}{$link_end}
                </span>
                <span class="pubTime">
                    {$dataStr}
                </span>
                <p class="content">{$this->data['content']}</p>
            </div>     
EOF;
        return $str;
    }
}