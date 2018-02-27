<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/23
 * Time: 20:58
 */

class UserModel extends Model
{
    public function getIndex($field=[]){
        //处理搜索数据
        $where = '1=1 ';
        if (!empty($field['keyword'])){
            $where .= "and (username like '%{$field['keyword']}%' or email like '%{$field['keyword']}%')";
        }

        //分页显示
        $page_size = $field['page_size']??4;
        //>>计算count totalPage
        $sql = "select count(id) from `user` where ".$where;
        $count = $this->pdo->fetchColumn($sql);
        $total_page = ceil($count/$page_size);

        //>>开始页和每页条数
        $page = intval($field['page']??1);
        $page = $page<1?1:$page;
        $page = $page>$total_page?$total_page:$page;
        $start = ($page-1)*$page_size;
        $limit = " limit {$start},{$page_size}";

        $sql = "select * from `user` where {$where} order by id desc {$limit}";
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
//        return $rs;
//    $fenye = new PageTools();
//    $rs = $fenye->myFenYe($field,'user');
//    return $rs;
    }
    public function getAdd_save($field){
        //先判断用户名必须大于3位
        if (strlen($field['username'])<3){
            $this->error = '用户名不能小于3位';
            return false;
        }
        //判断用户名在数据库的唯一性
            //>>1.根据名字去数据库读取数据如果数据存在则不可添加
            $sql = "select id from user where username='{$field['username']}'";
            $r = $this->pdo->fetchRow($sql);
            if (!empty($r)){
                $this->error = '该用户名已经存在!';
                return false;
            }
        //判定2次密码的相同
        if($field['pwd1']!==$field['pwd2']){
            $this->error = '两次输入的密码不一致';
            return false;
//            Tools::jump('两次输入的密码不一致','./index.php?c=User&a=index',3);
}
        $field['password']=Tools::myPwd($field['pwd1']);
        unset($field['pwd2']);
        unset($field['pwd1']);
        $sql = Tools::myInsert('user',$field);
        return $this->pdo->execute($sql);
    }
    public function getEdit($id){
        $id = addslashes($id);
        $sql = "select * from user where id={$id}";
        $user = $this->pdo->fetchRow($sql);
        return $user;
    }
    public function getEdit_save($field){
        $sql = Tools::myUpdate('user',$field);
        $this->pdo->execute($sql);
    }
    public function getDelete($id){
        $id = addslashes($id);
        //读取数据库的头像文件路径
        $sql = "select head from user where id={$id}";
        $del_head = $this->pdo->fetchColumn($sql);

        $sql = Tools::myDelete('user',$id);
        $this->pdo->execute($sql);
        //执行完删除数据库,就判断头像文件是否存在.存在就删除
        if (!empty($del_head)){
            unlink(__DIR__.'/../'.$del_head);
        }
    }
    public function getEdit_pwd_save($field){
        if($field['pwd1']!==$field['pwd2']){
            $this->error = '两次输入的密码不一致';
            return false;
//            Tools::jump('两次输入的密码不一致','./index.php?c=User&a=index',3);
        }
        $field['id'] = addslashes($field['id']);
        $sql = "select password from user where id={$field['id']}";
        $u_pwd = $this->pdo->fetchColumn($sql);
        if(Tools::myPwd($field['pwd'])!==$u_pwd){
            $this->error = '原始密码错误!';
            return false;
//            Tools::jump('原始密码错误!','./index.php?c=User&a=index',3);
}
        $pwd = Tools::myPwd($field['pwd1']);
        $sql = "update user set password='{$pwd}' where id={$field['id']}";
        return $this->pdo->execute($sql);
    }
    public function getHead($id){
        $sql = "select `head` from user where id={$id}";
        $r = $this->pdo->fetchRow($sql);
        return $r;
    }
}