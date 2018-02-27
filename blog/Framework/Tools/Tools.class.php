<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/19
 * Time: 17:36
 */

/**
 * 静态公用类成员方法
 * Class Tools
 */
class Tools
{
    //打印信息
    public static function myDump($mixed){
        echo '<pre>';
        var_dump($mixed);
//        die;
    }
/*    //跳转
    public static function jump($url,$msg='',$Refresh=0,$conn=null){
        $conn = is_null($conn) ? $GLOBALS['conn'] : $conn;
        $num=mysqli_affected_rows($conn);
        echo '<h2>',$msg,'<br/>影响数据的条数=>',$num,'</h2>';
        echo '<h2>',$msg,'</h2>';
        header('Refresh:'.$Refresh.';url='.$url);
        die;
    }*/
    /**
     * 跳转
     * @param $url  跳转的url
     * @param $msg   提示的信息
     * @param $time  等待时间,秒
     */
    protected static function jump($url,$msg='',$time=0){
        if(!headers_sent()){  //headers_sent检测header是否发送给浏览器
            //header没有发送,使用header跳转
            if($time==0){ //立即跳转
                header("Location: $url");
            }else{  //延迟跳转
                echo '<h1>'.$msg.'</h1>';  //跳转之前输出提示信息
                header("Refresh: $time;url=$url");
            }
        }else{
            if($time!=0){   //延时跳转
                echo '<h1>'.$msg.'</h1>';  //提示信息
                $time = $time * 1000;
            }
            //使用js跳转
            echo <<<JS
            <script type='text/javascript'>
                window.setTimeout(function(){
                  location.href = '{$url}';
                },{$time});
            </script>
JS;
        }
        exit;  //跳转之后没有必要再执行其他的代码.
    }
    //密码加密
    public static function myPwd($pwd){
        $pwd=$pwd.'bukesuiji'.$pwd;
        return md5(md5($pwd).'zhongzi');
    }
    //sql语句insert
    public static function myInsert($table,$field){
        $k='';
        $v='';
        foreach($field as $key => $value){
            $k.=("`{$key}`,");
            $v.=("'{$value}',");
        }
        $k=substr($k,0,-1);
        $v=substr($v,0,-1);
        return "INSERT INTO `{$table}` ({$k}) VALUES ({$v}) ";
    }
    //sql语句update
    public static function myUpdate($table,$field){
        $id=$field['id'];
        unset($field['id']);
        $str='';
        foreach($field as $key => $value){
            $str .= "`{$key}`='$value',";
        }
        $str=substr($str,0,-1);
        return "UPDATE `{$table}` SET {$str} WHERE `id`='{$id}'";
    }
    //sql语句delete
    public static function myDelete($table,$id){
        return "DELETE FROM `{$table}` WHERE `id`='{$id}'";
    }

    /**
     * call_user_func_array(第一个参数为回调函数,第二个参数为数组)
     * 对象上的方法:  回调函数为数组  ([对象,方法],数组)
     * 类上的静态方法:回调函数为数组 ([类名,方法],数组) 或者 ('类名::方法',数组)
     * @param $name  方法名
     * @param $arguments  参数数组
     * @param null $construct new对象时初始化的参数
     */
/*    public static function __callStatic($name,$arguments,$constructs=null)
    {
        include_once '../Config/autoload.php';
        call_user_func_array([DB::getInstance($constructs),$name],$arguments);
    }*/
    public static function __callStatic($name,$arguments)
    {
        call_user_func_array([new self(),$name],$arguments);
    }
}