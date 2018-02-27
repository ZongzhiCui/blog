<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/1
 * Time: 18:59
 */

class ArticleController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        $this->obj = new ArticleModel();
    }

    public function index(){
        $field = $_REQUEST;
        $field['page_size'] = 3;
        $arts = $this->obj->getAdminIndex($field);
        $this->assign($arts);
        $this->display('index');
    }

    /***
     * 下面的都需要修改的
     */
    public function add(){
        //判断这个是显示页面还是添加的提交 if  else
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $field = $_POST;
            //判断添加返回值 失败跳出去.成功就调到列表
            $rs = $this->obj->getAdd($field);
            if ($rs === false){
                Tools::jump('./index.php?p=Admin&c=Article&a=add',$this->obj->getError(),3);
            }
            Tools::jump('./index.php?p=Admin&c=Article&a=index');
        }else{
//            require CURRENT_VIEW_PATH.'add.html';
            $this->display('add');
        }
    }
    public function delete(){
        $id = $_GET['id'];
        $this->obj->getDelete($id);
        Tools::jump('./index.php?p=Admin&c=Article&a=index');
    }
    public function edit(){
        $id = addslashes($_GET['id']);
        $rs = $this->obj->getEdit($id);
        $this->assign('row',$rs);
        $this->display('edit');
    }
    public function edit_save(){
        $field = $_POST;
        /**判断是否有上传文件 有的话调用上传文件函数**/
        if ($_FILES['logo']['error'] != 4){
            //如果上传文件就要删除原来的文件,需要Model里有个方法先把 logo  thumb_logo读取出来
            //得到数据需要等到新的图片上传成功再删除-----------------------
            $unlink = $this->obj->getLogo($field['id']);
//            Tools::myDump($unlink);die;
            $file = $_FILES['logo'];
            $upload = new UploadTools();
            $logo = $upload->upload($file,'Brand/');
            if ($logo === false){
                Tools::jump("index.php?p=Admin&c=Article&a=edit&id={$field['id']}",$upload->getError(),3);
            }
            $field['logo'] = $logo;
            //微略图
            $thumb = new ImageTools();
            $thumb_logo = $thumb->thumb($logo,100,100);
            if ($thumb_logo === false){
                Tools::jump("index.php?p=Admin&c=Article&a=edit&id={$field['id']}",$thumb->getError(),3);
            }
            $field['thumb_logo'] = $thumb_logo;
            //这里删除修改前的那些图片------------------------------
            if (!empty($unlink)){
                if (is_file($unlink['logo'])){
                    unlink($unlink['logo']);
                    unlink($unlink['thumb_logo']);
                }
            }
        }
        //把数据写入数据库
        $r = $this->obj->getEdit_save($field);
        if ($r === false){
            Tools::jump("index.php?p=Admin&c=Article&a=edit&id={$field['id']}",$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Admin&c=Article&a=index');
    }
}