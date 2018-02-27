<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/19
 * Time: 14:33
 */

class MyArticleController extends PlatformController
{
    private $obj;
    public function __construct()
    {
        parent::__construct();
        $this->obj = ObjFactory::createObj('MyArticleModel');
        $cates = $this->obj->getCate();
        $this->assign('cates',$cates);
    }
    public function index(){
        $arts = $this->obj->getIndex();
        if (empty($arts)){
            echo '<h3>您还为发布过文章!</h3>';
            die;
        }
        $this->assign('arts',$arts);
        $this->display('index');
    }
    /**
     * 添加文章
     */
    public function add(){
        //需要分类ID,header里已经有分类的数据了这里直接显示数据就可以了
//        $cates = $this->obj->getCate();
//        $this->assign('cates',$cates);
        $this->display();
    }
    public function add_save(){
        $field = $_POST;
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=blog;charset=utf8;port=3306','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]);
        $dbh->beginTransaction();
        $r = $this->obj->getAdd_save($field);
        if ($r === false){
            $dbh->rollBack();
            Tools::jump('./index.php?p=Home&c=Article&a=add',$this->obj->getError(),3);
        }
        $dbh->commit();
        Tools::jump('./index.php?p=Home&c=Article&a=index');
    }
    public function keep(){
        $arts = $this->obj->getKeep();
        if (empty($arts)){
            echo '<h3>您还未收藏过文章!</h3>';
            die;
        }
        $this->assign('arts',$arts);
        $this->display('keep');
    }
    public function reply(){
        $arts = $this->obj->getReply();
        if (empty($arts)){
            echo '<h3>您还未回复过文章!</h3>';
            die;
        }
        $this->assign('arts',$arts);
        $this->display('reply');
    }
}