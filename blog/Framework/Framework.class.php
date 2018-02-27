<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/29
 * Time: 15:07
 */
class Framework
{
    /**
     * 让run方法执行整个流程
     */
    public static function run(){
        self::initAutoload();
        self::initPath();
        self::initConfig();
        self::initRequest();
        self::initMapping();
        self::dispache();
    }

    /**
     * 1.  初始化路径常量
     */
    private static function initPath(){
        defined('DS') or define('DS',DIRECTORY_SEPARATOR);   //将该常量起一个别名
        defined('ROOT_PATH') or define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).DS); //项目的根目录
        defined('APP_PATH') or define('APP_PATH',ROOT_PATH.'Application'.DS);  //Application的目录
        defined('FRAME_PATH') or define('FRAME_PATH',ROOT_PATH.'Framework'.DS);  //Framework的目录
        defined('TOOLS_PATH') or define('TOOLS_PATH',FRAME_PATH.'Tools'.DS);  //tools的目录
        defined('CONFIG_PATH') or define('CONFIG_PATH',APP_PATH.'Config'.DS);  //Config的目录
        defined('CONTROLLER_PATH') or define('CONTROLLER_PATH',APP_PATH.'Controller'.DS);  //Controller的目录
        defined('MODEL_PATH') or define('MODEL_PATH',APP_PATH.'Model'.DS);  //Model的目录
        defined('VIEW_PATH') or define('VIEW_PATH',APP_PATH.'View'.DS);  //VIEW的目录
        defined('PUBLIC_PATH') or define('PUBLIC_PATH',ROOT_PATH.'Public'.DS);  //Public的目录
        defined('UPLOADS_PATH') or define('UPLOADS_PATH',ROOT_PATH.'Uploads'.DS);  //Uploads的目录
    }

    /**
     * 加载配置文件
     */
    private static  function initConfig(){
        $GLOBALS['config'] = require  CONFIG_PATH.'application.config.php';
    }

    private static  function initRequest(){
        //>>1.接收请求的标识 c:控制器, a:控制器中的方法,p:平台
        $p = $_GET['p']??$GLOBALS['config']['app']['default_platform'];  //平台
        $c = $_GET['c']??$GLOBALS['config']['app']['default_controller'];  //控制器
        $a = $_GET['a']??$GLOBALS['config']['app']['default_action'];  //方法

        //将请求的平台,控制器,方法的名字作为常量. 常量没有作用域可以随处使用.
        defined('PLATFORM_NAME') or define('PLATFORM_NAME',$p);
        defined('CONTROLLER_NAME') or define('CONTROLLER_NAME',$c);
        defined('ACTION_NAME') or define('ACTION_NAME',$a);


//以下常量的值会随着用户访问的平台和控制器来确定.
        defined('CURRENT_CONTROLLER_PATH') or define('CURRENT_CONTROLLER_PATH',CONTROLLER_PATH.$p.DS); //正在访问当前控制在哪个平台的路径.
        defined('CURRENT_VIEW_PATH') or define('CURRENT_VIEW_PATH',VIEW_PATH.$p.DS.$c.DS); //正在访问当前控制在哪个平台的路径.
    }

    /**
     * 分发请求: 根据c找到控制器从而执行a指定的方法
     */
    private static  function dispache(){
        $controller_name = CONTROLLER_NAME . "Controller"; //控制器类的名字
        //>>2.加载控制器类文件并且创建对象
        $controller = new $controller_name();  //根据控制器的名字创建对象

        //>>3.执行控制器对象中的方法
        $a =  ACTION_NAME;
        $controller->$a();
    }

    /**
     * 类名和类文件的映射
     */
    private static  function initMapping(){
        //类和类文件的映射(每个规律类和目录的映射)
        $GLOBALS['map'] = array(
            'DB'=>TOOLS_PATH.'DB.class.php',
            'Tools'=>'./Framework/Tools/Tools.class.php',
            'PageTool'=>'./Framework/Tools/PageTool.class.php',
            'ObjFactory'=>'./Framework/Tools/ObjFactory.class.php',
            'Model'=>FRAME_PATH.'Model.class.php',
            'Controller'=>FRAME_PATH.'Controller.class.php'
        );
    }

    private static function initAutoload(){
        spl_autoload_register("Framework::userAutoload");//告知PHP说,当需要需要使用到类的自动加载时请求使用指定的函数.
    }

    /**
     * 该方法准备被PHP调用.
     * @param $class_name
     */
    private static  function userAutoload($class_name){
        if(isset($GLOBALS['map'][$class_name])){   //先判断map中是否有类对应的类文件路径
            require $GLOBALS['map'][$class_name];
        }elseif(substr($class_name,-10)=='Controller'){
            require CURRENT_CONTROLLER_PATH.$class_name.'.class.php';  //加载控制器
        }elseif(substr($class_name,-5)=='Model'){
            require MODEL_PATH.$class_name.'.class.php';  //加载模型
        }elseif(substr($class_name,-4)=='Tool'){
            require TOOLS_PATH.$class_name.'.class.php';  //加载工具类
        }
    }

}