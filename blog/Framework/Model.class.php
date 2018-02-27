<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/4
 * Time: 12:42
 */

abstract class Model
{
    //保存DB对象
    protected $pdo;
    public function __construct()
    {
//        $config = require CONFIG_PATH.'application.config.php';
        //已经在写在超全局里面
        $this->pdo = DB::getInstance($GLOBALS['config']['pdo']);
    }
    //保存错误信息
    protected $error;
    public function getError(){
        return $this->error;
    }
    //加一个header头上的 读取分类表的方法
    public function getCate($table='category'){
        $sql = "select * from {$table} order by id desc";
        $categorys = $this->pdo->fetchAll($sql);
        $cates = $this->getChildren($categorys,0);
        return $cates;
    }
    /**
     * 找儿子的方法
     * @param $categoryList 所有的数据
     * @param $parent_id 要找哪个分类的儿子，传入对于分类的id
     * @param $deep 层级
     * @return  返回对应分类的子孙分类
     */
    private function getChildren(&$categoryList,$pkey,$deep=0){
        static $children = [];//保存找到的儿子
        //循环所有的数据，比对每条数据中的parent_id,如果等于传入的$parent_id说明儿子找到了
        foreach ($categoryList as $child){
            if($child['pkey'] == $pkey){
                //将找到的儿子保存到数组中
//                $child['deep'] = $deep;//每个找到的儿子上保存层级
                $child['name_txt'] = str_repeat("○",$deep*2).$child['name'];//保存有缩进的名称
                $children[] = $child;//节点AAA
                //由于找到的 节点AAA 它还有儿子 继续查找
                $this->getChildren($categoryList,$child['id'],$deep+1);
            }
        }
        //返回找到的儿子
        return $children;
    }
}