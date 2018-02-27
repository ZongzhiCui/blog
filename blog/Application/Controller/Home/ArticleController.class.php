<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/14
 * Time: 15:25
 */

class ArticleController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        $this->obj = ObjFactory::createObj('ArticleModel');
        $cates = $this->obj->getCate();
        $this->assign('cates',$cates);
    }
    public function index(){
        if (isset($_GET['id'])){ //分类ID
            $id = addslashes($_GET['id']);
        }
        $id = $id??'1=1';
        $field = $_REQUEST;
        $arts = $this->obj->getIndex($id,$field);
        $this->assign($arts);//相关文章

        $this->display('index');
    }
    public function content(){
        $id = addslashes($_GET['id']);
        $art = $this->obj->getContent($id);
        $this->assign('row',$art);
        $this->display('single');
    }

    /**
     * 保存回复内容
     */
    public function reply_save(){
        $field = $_POST;
        $r = $this->obj->getReply_save($field);
        if ($r === false){
            Tools::jump('./index.php?p=Home&c=Article&a=index',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }

    /**
     * 删除回复内容
     */
    public function reply_delete(){
        $id = addslashes($_GET['id']);
        $r = $this->obj->getReply_delete($id);
        if ($r === false){
            Tools::jump('./index.php?p=Home&c=Article&a=index',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }
    //删除文章，假删除
    public function delete(){
        $id = addslashes($_GET['id']);
        $r = $this->obj->getDelete($id);
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }
    //收藏文章.当前登录的用户相关
    public function collect(){
        $id = addslashes($_GET['id']);
        $r = $this->obj->getCollect($id);
        if ($r === false){
            Tools::jump('./index.php?p=Home&c=Article&a=index',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }
    //修改文章 回显
    public function edit(){
        $id = addslashes($_GET['id']);
        $rs = $this->obj->getEdit($id);
        $this->assign('row',$rs);
        $this->display('edit');
    }
    public function edit_save(){
        $field = $_POST;
        $r = $this->obj->getEdit_save($field);
        if ($r === false){
            Tools::jump('./index.php?p=Home&c=Article&a=index',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }

    public function comments(){
        $arts = $this->obj->getComments();
        $this->assign('arts',$arts);//相关文章
        $this->display();
    }
    public function collects(){
        $arts = $this->obj->getCollects();
        $this->assign('arts',$arts);//相关文章
        $this->display();
    }
}