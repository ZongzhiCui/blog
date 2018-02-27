<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/26
 * Time: 14:11
 */

class MyJumpController extends PlatformController
{
    public function dashboard(){
        @session_start();
        require VIEW_PATH.'Admin/User/dashBoard.html';
    }
    public function manageblog(){
        @session_start();
        require VIEW_PATH.'Admin/User/manageblog.html';
    }
    public function messages(){
        @session_start();
        require VIEW_PATH.'Admin/User/messages.html';
    }
    public function reports(){
        @session_start();
        require VIEW_PATH.'Admin/User/reports.html';
    }
}