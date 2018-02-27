<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/19
 * Time: 18:03
 */
/**
 * 测试分页的类!
 * @param $db
 * @param $table
 * @param $length
 * @param $page
 * @param string $where
 * @return array
 */
class PageTool{
    public function myFenYe($field,$table){
        //拼接搜索的条件
        $where = '1=1 ';
        if (!empty($field['status'])){
            $where .= "and (status&{$field['status']})>0 ";
        }
        if (!empty($field['is_onsale'])){
            $where .= "and is_onsale={$field['is_onsale']}-1 ";
        }
        if (!empty($field['keyword'])){
            $where .= "and (name like '%{$field['keyword']}%' or intro like '%{$field['keyword']}%') ";
        }
        //分页显示
        $page_size = $field['page_size']??4;
        //>>计算count totalPage
        $sql = "select count(id) from {$table} where ".$where;
        $count = $this->obj->fetchColumn($sql);
        $total_page = ceil($count/$page_size);

        //>>开始页和每页条数
        $page = intval($field['page']??1);
        $page = $page<1?1:$page;
        $page = $page>$total_page?$total_page:$page;
        $start = ($page-1)*$page_size;
        $limit = " limit {$start},{$page_size}";


        $sql = "select * from {$table} where ".$where." order by id desc ".$limit ;
        $rs = $this->obj->fetchAll($sql);
        return [
            'rs'=>$rs,
            'count'=>$count,
            'total_page'=>$total_page,
            'page'=>$page,
            'page_size'=>$page_size
        ];
    }
//外部使用extract(fenye());$start,$length,$total_page
//分页的第二个函数.显示页码及优化
    /**
     * 这个静态方法 页码工具条
     * @param $page
     * @param $page_size
     * @param $total_page
     * @return string
     */
    public  static function myYeMa($page,$page_size,$total_page){
        if($total_page<=1){
            return '';
        }
        $start_page=$page-$page_size;
        $end_page=$page+$page_size;
        //如果
        if($start_page <= 0){
            $start_page=1;
            if($start_page+2*$page_size <= $total_page){
                $end_page=$start_page+2*$page_size;
            }else{
                $end_page=$total_page;
            }
        }
        if($end_page > $total_page){
            $end_page = $total_page;
            if($end_page-2*$page_size >=1){
                $start_page=$end_page-2*$page_size;
            }else{
                $start_page=1;
            }
        }
//        $keywords=addslashes($_GET);
        unset($_REQUEST['page']);
        $url_params = http_build_query($_REQUEST);

        $prev = $page-1<1?1:$page-1;
        $next = $page+1>$total_page?$total_page:$page+1;
        $html=<<<xxx
    <div id="clear1">
    <a class="page1 move" href="?{$url_params}&page=1">第一页</a>
    <a class="page1 move" href="?{$url_params}&page={$prev}">上一页</a>
xxx;

        for($i=$start_page;$i<=$end_page;$i++):
            $class=$page==$i?'on':'';
            $html.=<<<yyy
    <a class="page1 $class" href="?{$url_params}&page={$i}">$i</a>
yyy;
        endfor;
        $html.=<<<zzz
    <a class="page1 move" href="?{$url_params}&page={$next}">下一页</a>
    <a class="page1 move" href="?{$url_params}&page={$total_page}">最末页</a>
    </div>

zzz;
        return $html;
    }
//$a=<<<xxx
//<div>
//    <style>
//        .page1{
//            background: #f2f8ff;
//            border: 1px solid #e1e2e3;
//            width: 34px;
//            height: 34px;
//            cursor: pointer;
//            display: block;
//            text-align: center;
//            line-height: 34px;
//            float: left;
//            font-size: 15px;
//            margin: 0 5px;
//        }
//        #clear{
//            overflow: hidden;
//            width: 500px;
//            border: 0;
//        }
//        .move{
//            width: 88px;
//        }
//        .on{
//            border: 0;
//            width: 36px;
//            height: 36px;
//            line-height: 36px;
//            font-weight: bold;
//            color: #333;
//        }
//    </style>
//</div>
//xxx;
}
