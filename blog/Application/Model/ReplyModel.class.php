<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/26
 * Time: 18:03
 */

class ReplyModel extends Model
{
    public function getIndex($field){
        //分页和搜索
        $where = '1=1 ';
        if (!empty($field['keyword'])){
            $where .= "and (comment like '%{$field['keyword']}%')";
        }

        //分页显示
        $page_size = $field['page_size']??4;
        //>>计算count totalPage
        $sql = "select count(id) from `reply` where ".$where;
        $count = $this->pdo->fetchColumn($sql);
        $total_page = ceil($count/$page_size);

        //>>开始页和每页条数
        $page = intval($field['page']??1);
        $page = $page<1?1:$page;
        $page = $page>$total_page?$total_page:$page;
        $start = ($page-1)*$page_size;
        $limit = " limit {$start},{$page_size}";

        $sql = "select * from reply where {$where} order by id desc {$limit}";
        $rs = $this->pdo->fetchAll($sql);
/*        foreach ($arts as &$value){
            $sql = "select u.username,r.* from reply r LEFT JOIN user u on r.user_id=u.id where (r.art_id={$value['id']} and r.status=0) order by id desc";
            $reply = $this->pdo->fetchAll($sql);
            $value['reply'] = $reply;
        }*/
        $html = PageTool::myYeMa($page,$page_size,$total_page);
        return [
            'rs'=>$rs,
            'count'=>$count,
            'total_page'=>$total_page,
            'page'=>$page,
            'page_size'=>$page_size,
            'html'=>$html
        ];
    }
    public function getDelete($id){
        $sql = Tools::myDelete('reply',$id);
        $r = $this->pdo->execute($sql);
        return $r;
    }
}