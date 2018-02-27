<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/20
 * Time: 16:38
 */

class CategoryController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        $this->obj = new CategoryModel();
    }
    public function index(){
        $rs = $this->obj->getIndex();
        $this->assign('rs',$rs);
        $this->display('index');
    }
    public function add(){
        $cates = $this->obj->getCate();
        $this->assign('cates',$cates);
        $this->display('add');
    }
    public function add_save(){
        $field = $_POST;
        $r = $this->obj->getAdd_save($field);
        if ($r === false){
            Tools::jump('./index.php?p=Admin&c=Category&a=add',$this->obj->getError(),3);
        }
        Tools::jump('./index.php?p=Admin&c=Category&a=index');
    }
}