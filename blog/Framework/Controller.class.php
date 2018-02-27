<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/29
 * Time: 14:46
 */
class Controller
{
    private $datas = []; //存放数据容器. 该容器中的数据需要在页面中使用到.

    /**
     * 加载当前控制器对应的视图文件夹下的模板
     * @param $template 模板的名字 可以不传,使用方法名作为模板的名称
     */
    public function display($template=''){
        if(empty($template)){//没有传入模板文件的名称
            $template = ACTION_NAME;
        }
        //将关联数组导入到当前符号表,键名作为变量,键值变量的值
        extract($this->datas);
        require CURRENT_VIEW_PATH."{$template}.html";
        exit;
    }

    /**
     * 将数据放到$data中
     * @param $name
     * @param $value
     */
    public function assign($name,$value=''){
        if(is_array($name)){
            //如果name是数组,将$name的数据直接合并到$datas中
            $this->datas = array_merge($this->datas,$name);  //$name = array('key1'=>value1,'key2'=>value2);
        }else{
            $this->datas[$name] = $value;
        }
    }



    /**
     * 跳转
     * @param $url  跳转的url
     * @param $msg   提示的信息
     * @param $time  等待时间,秒
     */
    protected static function redirect($url,$msg='',$time=0){
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

}