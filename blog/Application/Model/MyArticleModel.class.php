<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/19
 * Time: 14:34
 */

class MyArticleModel extends Model
{
    public function getIndex(){
        //读取我的发表的文章,session['admin']['id'] = 文章里的['user_id']
        @session_start();
        $sql = "select * from article where user_id={$_SESSION['admin']['id']}";
        $arts = $this->pdo->fetchAll($sql);
        return $arts;
    }
    public function getCate($table='category'){
        $cates = parent::getCate($table='category');
        return $cates;
    }
    public function getAdd_save($field){
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
        //把修改时间写进去
        $field['edit_time'] = time();
        //把当前用户名字添加进去
        @session_start();
        $field['user_id'] = $_SESSION['admin']['id'];
        $sql = Tools::myInsert('article',$field);
        $num = $this->pdo->execute($sql);
        if ($num === false){
            $this->error = '添加数据失败!';
            return false;
        }
        return $num;
    }

    /**
     * @return array 当前用户收藏的文章
     */
    public function getKeep(){
        //先读取收藏表里面USERID 等于 session保存的id
        @session_start();
        $sql = "select * from keep where user_id={$_SESSION['admin']['id']}";
        $keep = $this->pdo->fetchAll($sql);
        //遍历出收藏表里所有的文章ID放入到数组中
        $keeps = [];
        foreach($keep as $val){
            $keeps[] = $val['art_id'];
        }
        //读取文章表,遍历所有,当文章ID在数组keep中时保存到arts里
        $sql = "select * from article";
        $article = $this->pdo->fetchAll($sql);
        $arts = [];
        foreach ($article as $value){
            if (in_array($value['id'],$keeps)){
                $arts[] = $value;
            }
        }
        return $arts;
    }

    public function getReply(){
        @session_start();
        $sql = "select * from reply where user_id={$_SESSION['admin']['id']}";
        $reply = $this->pdo->fetchAll($sql);
        //遍历出回复表里所有的文章ID放入到数组中
        $replys = [];
        foreach($reply as $val){
            $replys[] = $val['art_id'];
        }
        //读取文章表,遍历所有,当文章ID在数组replys中时保存到arts里
        $sql = "select * from article";
        $article = $this->pdo->fetchAll($sql);
        $arts = [];
        foreach ($article as $value){
            if (in_array($value['id'],$replys)){
                $arts[] = $value;
            }
        }
        return $arts;
    }
}