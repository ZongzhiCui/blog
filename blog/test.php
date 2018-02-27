<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/10
 * Time: 13:13
 */
header('Content-Type: text/html;charset=utf-8');
//include_once './Framework/Tools/Tools.class.php';
$string = "This is\tan example\nstring";
/* 使用制表符和换行符作为分界符 */
$tok = strtok($string, " \n\t");

while ($tok !== false) {
    echo "Word=$tok<br />";
    $tok = strtok(" \n\t");
}