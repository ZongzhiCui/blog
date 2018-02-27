<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/26
 * Time: 18:01
 */

class ReplyController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        $this->obj = new ReplyModel();
    }

    public function index(){
        $field = $_REQUEST;
        $field['page_size'] = 3;
        $replys = $this->obj->getIndex($field);
        $this->assign($replys);
        $this->display('index');
    }
    public function delete(){
        $id = addslashes($_GET['id']);
        $r = $this->obj->getDelete($id);
        Tools::jump('./index.php?p=Admin&c=Reply&a=index',$this->obj->getError(),3);
    }
}