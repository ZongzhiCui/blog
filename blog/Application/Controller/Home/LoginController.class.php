<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/12
 * Time: 14:09
 */

class LoginController extends Controller
{
    private $obj;

    //构造方法 创建DB对象给下面的方法使用
    public function __construct()
    {
        $this->obj = new LoginModel();
    }
    public function index(){
        session_start();
        if (isset($_SESSION['admin'])) {
            Tools::jump('./index.php?p=Home&c=Home&a=edit');
        }
        if (isset($_COOKIE['id']) && isset($_COOKIE['password'])) {
            $id = $_COOKIE['id'];
            $pwd = $_COOKIE['password'];
            $obj = ObjFactory::createObj('LoginModel');
            $r = $obj->getCookie_check($id, $pwd);
            //判断返回结果如果全等于false则输出错误信息,并跳到登录界面
            if ($r === false) {
                Tools::jump('./index.php?p=Home&c=Login&a=index', $obj->getError(), 3);
            }
            Tools::jump('./index.php?p=Home&c=Home&a=edit');
        }
        $this->display('index');
    }
    public function add_save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $field = $_POST;
                //这里判断上传文件
                if ($_FILES['head']['error'] != 4){
                    //接收到文件数据 实现上传文件的功能
                    $file = $_FILES['head'];
                    //UploadTools对象里的upload来实现上传
                    $upload = new UploadTool();
                    $head = $upload->upload($file,'Admin/');
//                返回值 失败跳转到添加,成功就写$field 实现加入数据库
                    if ($head === false){
                        Tools::jump('./index.php?p=Home&c=Login&a=add_save',$upload->getError(),3);
                    }
                    //拿到上传的原图 制作一个缩略图
                    $thumb = new ImageTool();
                    $thumb_logo = $thumb->thumb($head,100,80);
                    if ($thumb_logo === false){
                        Tools::jump('./index.php?p=Home&c=Login&a=add_save',$thumb->getError(),3);
                    }
                    unlink(__DIR__.'/../'.$head);
                    $field['head'] = $thumb_logo;
                }
                $user_add = new UserModel();
                $r = $user_add->getAdd_save($field);
                if ($r === false){
                    Tools::jump($this->obj->getError(),'./index.php?p=Home&c=Home&a=index',3);
                }
                Tools::jump('./index.php?p=Home&c=Home&a=index','插入数据成功',1);
        }else{
            $this->display('add_save');
        }
    }
    public function login_check()
    {
        $field = $_POST;
        $r = $this->obj->getLogin_check($field);
        if ($r === false) {
            Tools::jump('./index.php?p=Home&c=Login&a=index', $this->obj->getError(), 3);
        }
        Tools::jump('./index.php?p=Home&c=Home&a=index');
    }

    public function logout()
    {
        @session_start();
        unset($_SESSION['admin']);
        setcookie('id', null, -1, '/');
        setcookie('password', null, -1, '/');
        Tools::jump('./index.php?p=Home&c=Login&a=index');
    }
}