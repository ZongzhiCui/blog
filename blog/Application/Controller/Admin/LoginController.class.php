<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/26
 * Time: 11:50
 */

class LoginController extends Controller
{
    private $obj;

    //构造方法 创建DB对象给下面的方法使用
    public function __construct()
    {
        $this->obj = new LoginModel();
    }

    public function index()
    {
        session_start();
        if (isset($_SESSION['admin'])) {
            Tools::jump('./index.php?p=Admin&c=Home&a=home');
        }
        if (isset($_COOKIE['id']) && isset($_COOKIE['password'])) {
            $id = $_COOKIE['id'];
            $pwd = $_COOKIE['password'];
            $obj = ObjFactory::createObj('LoginModel');
            $r = $obj->getCookie_check($id, $pwd);
            //判断返回结果如果全等于false则输出错误信息,并跳到登录界面
            if ($r === false) {
                Tools::jump('./index.php?p=Admin&c=Login&a=index', $obj->getError(), 3);
            }
            Tools::jump('./index.php?p=Admin&c=Home&a=home');
        }
//        require CURRENT_VIEW_PATH.'index.html';
        $this->display('index');
    }

    public function login_check()
    {
        $field = $_POST;
        $r = $this->obj->getLogin_check($field);
        if ($r === false) {
            Tools::jump('./index.php?p=Admin&c=Login&a=index', $this->obj->getError(), 3);
        }
        Tools::jump('./index.php?p=Admin&c=Home&a=home');
    }

    public function logout()
    {
        @session_start();
        unset($_SESSION['admin']);
        setcookie('id', null, -1, '/');
        setcookie('password', null, -1, '/');
        Tools::jump('./index.php?p=Admin&c=Login&a=index');
    }
}