<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/26
 * Time: 11:50
 */

class LoginModel extends Model
{
    public function getLogin_check($field){
        //先验证验证码
        $random = $field['random_code'];
            //验证码不区分大小写  strtolower()  二进制比较字符串 strcasecmp不区分大小写比较 相等 =0
        @session_start();
        if (strtolower($_SESSION['random_code']) != strtolower($random)){
            $this->error = '验证码输入错误!';
            return false;
        }
//        $field = addslashes($field);
        $sql = "select * from `user` where username='{$field['username']}'";
        $admin = $this->pdo->fetchRow($sql);
        if(empty($admin)){
            $this->error = '用户名不存在';
            return false;
        }
        if($admin['password']!=Tools::myPwd($field['password'])){
            $this->error = '密码不正确';
            return false;
        }
        //登录成功写session
        @session_start();
        $_SESSION['admin'] = $admin;
        //判断是否勾选记住密码,如果勾选就把id和密码保存到cookie
        if (isset($field['remember'])){
            //strtotime('+1 week')
            setcookie('id',$admin['id'],time()+7*24*3600,'/');
            setcookie('password',md5('cookie'.$admin['password']),strtotime("+1 week"),'/');
        }
        //更新登录时间和ip
        $last['id'] = $admin['id'];
        $last['last_login_time'] = time();
        $last['last_login_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
        $sql = Tools::myUpdate('user',$last);
        return $this->pdo->execute($sql);
    }
    /**
     * 这个方法用来检测cookie中保存的用户id和密码是否正确实现自动登录
     */
    public function getCookie_check($id,$pwd){
        $sql = "select * from `user` where id='{$id}'";
        $admin = $this->pdo->fetchRow($sql);
        if (empty($admin)){
            $this->error = '用户id不存在';
            return false;
        }
        if (md5('cookie'.$admin['password']) != $pwd){
            $this->error = '用户id或密码不正确';
            return false;
        }
        @session_start();
        $_SESSION['admin'] = $admin;
    }
}