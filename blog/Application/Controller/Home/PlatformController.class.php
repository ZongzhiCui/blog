<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/28
 * Time: 19:12
 */

class PlatformController extends Controller
{
    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['admin'])){
            if (isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                $id = $_COOKIE['id'];
                $pwd = $_COOKIE['password'];
                $obj = ObjFactory::createObj('LoginModel');
                $r = $obj->getCookie_check($id,$pwd);
                //判断返回结果如果全等于false则输出错误信息,并跳到登录界面
                if ($r === false){
                    Tools::jump('./index.php?p=Admin&c=Login&a=index',$obj->getError(),3);
                }
                return;
            }
            Tools::jump('./index.php?p=Admin&c=Login&a=index');
        }
    }
}