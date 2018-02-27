<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/3
 * Time: 21:20
 */

class HomeController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        @session_start();
        $this->obj = ObjFactory::createObj('HomeModel');
    }
    public function home(){
//        include './View/Home/home.html';
        $this->display('home');
    }
    public function edit(){
        $field = $_POST;
        $r = $this->obj->getEdit($field);
        if ($r === false){
            Tools::jump("index.php?c=Home&a=home",$this->obj->getError(),3);
        }
        Tools::jump('./index.php?c=Login&a=index');
    }
}

//class_implements()