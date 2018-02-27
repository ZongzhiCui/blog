<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/14
 * Time: 15:59
 */

class ArticleModel extends Model
{
    public function getIndex($id,$field){
        //分页和搜索
        $where = '1=1 ';
        if (!empty($field['keyword'])){
            $where .= "and (title like '%{$field['keyword']}%' or intro like '%{$field['keyword']}%' or content like '%{$field['keyword']}%')";
        }

        //分页显示
        $page_size = $field['page_size']??4;
        //>>计算count totalPage
        $sql = "select count(id) from `article` where status=1 and ".$where;
        $count = $this->pdo->fetchColumn($sql);
        $total_page = ceil($count/$page_size);

        //>>开始页和每页条数
        $page = intval($field['page']??1);
        $page = $page<1?1:$page;
        $page = $page>$total_page?$total_page:$page;
        $start = ($page-1)*$page_size;
        $limit = " limit {$start},{$page_size}";

        $sql = "select * from article where cate_id='{$id}' and status=1 and {$where} order by id desc {$limit}";
        $arts = $this->pdo->fetchAll($sql);
        foreach ($arts as &$value){
            $sql = "select u.username,r.* from reply r LEFT JOIN user u on r.user_id=u.id where (r.art_id={$value['id']} and r.status=0) order by id desc";
            $reply = $this->pdo->fetchAll($sql);
            $value['reply'] = $reply;
        }
        $html = PageTool::myYeMa($page,$page_size,$total_page);
        return [
            'arts'=>$arts,
            'count'=>$count,
            'total_page'=>$total_page,
            'page'=>$page,
            'page_size'=>$page_size,
            'html'=>$html
        ];
    }
    public function getContent($id){
//        $sql = "select * from article where id={$id}";
        $sql = "select u.username,a.* from article a LEFT JOIN user u ON a.user_id=u.id where a.id={$id}";
        $art = $this->pdo->fetchRow($sql);
        return $art;
    }

    public function getAdd($field){
        //这里判断上传文件
        if ($_FILES['logo']['error'] != 4){
            //接收到文件数据 实现上传文件的功能
            $file = $_FILES['logo'];
            //UploadTools对象里的upload来实现上传
            $upload = new UploadTools();
            $brand_logo = $upload->upload($file,'Article/');
//                返回值 失败跳转到添加,成功就写$field 实现加入数据库
            if ($brand_logo === false){
                Tools::jump('./index.php?p=Admin&c=Article&a=add',$upload->getError(),3);
            }
            $field['logo'] = $brand_logo;
            //拿到上传的原图 制作一个缩略图
            $thumb = new ImageTools();
            $thumb_logo = $thumb->thumb($brand_logo,100,100);
            if ($thumb_logo === false){
                Tools::jump('./index.php?p=Admin&c=Article&a=add',$thumb->getError(),3);
            }
            $field['thumb_logo'] = $thumb_logo;
        }

        $sql = Tools::myInsert('Article',$field);
        $num = $this->pdo->execute($sql);
        return $num;
    }
    /**
     * 下面2个是回复内容的保存和删除
     */
    public function getReply_save($field){
        if (isset($field['nick']) && $field['nick']==7){ //说明要匿名评论
            $field['user_id'] = $field['nick'];//因为7是用户表里来保存匿名的
        }
        $sql = Tools::myInsert('reply',$field);
        $r = $this->pdo->execute($sql);
        $sql = "update article set comments=comments+1 where id={$field['art_id']}";
        $collect = $this->pdo->execute($sql);
        return $r;
    }
    public function getReply_delete($id){
        $field['id'] = $id;
        $field['status'] = -1;
        $sql = Tools::myUpdate('reply',$field);
        $r = $this->pdo->execute($sql);
        return $r;
    }
    //文章删除 上下2个可以合并 多传一个表名就可以实现
    public function getDelete($id){
        $field['id'] = $id;
        $field['status'] = -1;
        $sql = Tools::myUpdate('article',$field);
        $r = $this->pdo->execute($sql);
        return $r;
    }
    //当前登录用户 对 文章收藏,
    public function getCollect($id){
        $this->pdo->beginTransaction(); //开启事务
        @session_start();
        /**
         * 这里先做一个判断如果这个用户已经收藏过这篇文章就不让搜藏了
         */
        $sql = "select * from keep where user_id={$_SESSION['admin']['id']}";
        $rs = $this->pdo->fetchAll($sql);
        if (!empty($rs)){
            $arr = [];
            foreach ($rs as $valu){
                $arr[] = $valu['art_id'];
            }
            if (in_array($id,$arr)){
                $this->error = '您已经收藏过该文章!';
                return false;
            }
        }

        /**
         * 可以搜藏就保存文章到搜藏表 并且在文章搜藏字段➕1
         */
        $sql = "insert into keep set art_id={$id},user_id={$_SESSION['admin']['id']}";
        $r = $this->pdo->execute($sql);
        if ($r === false){
            $this->pdo->rollBack();  //出错就回滚
        }
        $sql = "update article set collect=collect+1 where id={$id}";
        $collect = $this->pdo->execute($sql);
        if ($collect === false){
            $this->pdo->rollBack(); //出错就回滚
        }
        $this->pdo->commit(); //全部成功就提交事务
        return $r;
    }
    //文章回显
    public function getEdit($id){
//        $sql = "select u.username,a.* from article a LEFT JOIN user u ON a.user_id=u.id where a.id={$id}"; 不能用联表 需要显示出所有的用户列表.
        $sql = "select * from article where id={$id}";
        $r = $this->pdo->fetchRow($sql);
        $sql = "select * from user ";
        $user = $this->pdo->fetchAll($sql);
        $r['user'] = $user;
        //分类表
/*        foreach ($r as &$val){
            $sql = "select * from category";
            $cates = $this->pdo->fetchAll($sql);
        }*/
        $cates = $this->getCate();
        $r['cates'] = $cates;
        return $r;
    }
    public function getEdit_save($field){
        if ($_FILES['logo']['error'] != 4){
            $file = $_FILES['logo'];
            $upload = new UploadTool();
            $logo = $upload->upload($file,'Article/');
            if ($logo === false){
                $this->error = $upload->getError();
                return false;
            }
            $field['logo'] = $logo;
            $imagetool = new ImageTool();
            $thumb_logo = $imagetool->thumb($logo,180,100);
            if ($thumb_logo === false){
                $this->error = $imagetool->getError();
                return false;
            }
            $field['thumb_logo'] = $thumb_logo;
        }
        //判断POST数据的有效性
        if (mb_strlen($field['title']) < 2){
            $this->error = '文章标题不能小于2个字!';
            return false;
        }
//        //把修改时间写进去
//        $field['edit_time'] = time();
        $sql = Tools::myUpdate('article',$field);
        $num = $this->pdo->execute($sql);
        if ($num === false){
            $this->error = 'edit数据失败!';
            return false;
        }
        return $num;
    }

    /**
     * 后台首页处理数据
     */
    public function getAdminIndex($field=[]){
        $where = '1=1 ';
        if (!empty($field['keyword'])){
            $where .= "and (title like '%{$field['keyword']}%' or content like '%{$field['keyword']}%' or intro like '%{$field['keyword']}%' )";
        }

        //分页显示
        $page_size = $field['page_size']??4;
        //>>计算count totalPage
        $sql = "select count(id) from `article` where ".$where;
        $count = $this->pdo->fetchColumn($sql);
        $total_page = ceil($count/$page_size);

        //>>开始页和每页条数
        $page = intval($field['page']??1);
        $page = $page<1?1:$page;
        $page = $page>$total_page?$total_page:$page;
        $start = ($page-1)*$page_size;
        $limit = " limit {$start},{$page_size}";

        $sql = "select * from `article` where {$where} order by id desc {$limit}";
        $rs = $this->pdo->fetchAll($sql);
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
    public function getLogo($id){
        $sql = "select logo,thumb_logo from Article where id={$id}";
        $r = $this->pdo->fetchRow($sql);
        return $r;
    }


    public function getComments(){
        $sql = "select * from article where comments>1 order by comments desc";
        $arts = $this->pdo->fetchAll($sql);
        foreach ($arts as &$value){
            $sql = "select u.username,r.* from reply r LEFT JOIN user u on r.user_id=u.id where (r.art_id={$value['id']} and r.status=0) order by id desc limit 0,12";
            $reply = $this->pdo->fetchAll($sql);
            $value['reply'] = $reply;
        }
        return $arts;
    }
    public function getCollects(){
        $sql = "select * from article where collect>1 order by collect desc";
        $arts = $this->pdo->fetchAll($sql);
        foreach ($arts as &$value){
            $sql = "select u.username,r.* from reply r LEFT JOIN user u on r.user_id=u.id where (r.art_id={$value['id']} and r.status=0) order by id desc limit 0,12";
            $reply = $this->pdo->fetchAll($sql);
            $value['reply'] = $reply;
        }
        return $arts;
    }
}