<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/23
 * Time: 20:58
 */

class UserController extends PlatformController
{
    private $obj;
    //构造方法 创建DB对象给下面的方法使用
    public function __construct()
    {
        parent::__construct();
        $this->obj = new UserModel();
    }
    public function index(){
$field = $_REQUEST;
$field['page_size'] = 3;
        $users = $this->obj->getIndex($field);
        $this->assign($users);
        $this->display('user_list');
    }
    public function add_save(){
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
                Tools::jump('./index.php?p=Admin&c=User&a=add',$upload->getError(),3);
            }
            //拿到上传的原图 制作一个缩略图
            $thumb = new ImageTool();
            $thumb_logo = $thumb->thumb($head,100,80);
            if ($thumb_logo === false){
                Tools::jump('./index.php?p=Admin&c=User&a=add',$thumb->getError(),3);
            }
            unlink(__DIR__.'/../'.$head);
            $field['head'] = $thumb_logo;
        }

        $r = $this->obj->getAdd_save($field);
        if ($r === false){
            Tools::jump($this->obj->getError(),'./index.php?p=Admin&c=User&a=index',3);
        }
        Tools::jump('./index.php?p=Admin&c=User&a=index','插入数据成功',1);
    }
    public function edit(){
//        if(strcmp($_SERVER['REQUEST_METHOD'],'POST')===0){echo '修改保存页面';}else{echo '修改回显页面';};
        $id=$_GET['id'];
        $user= $this->obj->getEdit($id);
        require CURRENT_VIEW_PATH.'user_edit.html';
    }
    public function edit_save(){
        $field = $_POST;
        /**判断是否有上传文件 有的话调用上传文件函数**/
        if ($_FILES['head']['error'] != 4){
            //如果上传文件就要删除原来的文件,需要Model里有个方法先把 logo  thumb_logo读取出来
            //得到数据需要等到新的图片上传成功再删除-----------------------
            $unlink = $this->obj->getHead($field['id']);
//            Tools::myDump($unlink);die;
            $file = $_FILES['head'];
            $upload = new UploadTools();
            $logo = $upload->upload($file,'Admin/');
            if ($logo === false){
                Tools::jump("index.php?p=Admin&c=User&a=edit&id={$field['id']}",$upload->getError(),3);
            }
            //微略图
            $thumb = new ImageTools();
            $thumb_logo = $thumb->thumb($logo,100,80);
            if ($thumb_logo === false){
                Tools::jump("index.php?p=Admin&c=User&a=edit&id={$field['id']}",$thumb->getError(),3);
            }
            unlink(__DIR__.'/../'.$logo);
            $field['head'] = $thumb_logo;
            //这里删除修改前的那些图片------------------------------
            if (!empty($unlink)){
                unlink(__DIR__.'/../'.$unlink['head']);
            }
        }
        $this->obj->getEdit_save($field);
        Tools::jump('./index.php?p=Admin&c=User&a=index','修改成功!',1);
    }
    public function delete(){
        $id = $_GET['id'];
        $this->obj->getDelete($id);
        Tools::jump('./index.php?p=Admin&c=User&a=index','删除成功!',1);
    }
    public function edit_pwd(){
        $id=$_GET['id'];
        require CURRENT_VIEW_PATH.'user_edit_pwd.html';
    }
    public function edit_pwd_save(){
        $field = $_POST;
        $r = $this->obj->getEdit_pwd_save($field);
        if ($r === false){
            Tools::jump('./index.php?p=Admin&c=User&a=index',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Admin&c=User&a=index','修改成功!',1);
    }
    public function logout(){
        session_start();
        unset($_SESSION['user']);
        Tools::jump('./index.php?p=Admin&c=user&a=index');
    }
}