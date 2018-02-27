<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/1
 * Time: 12:01
 */

class UploadTool
{
    //error
    private $error;
    public function getError(){
        return $this->error;
    }

    /**
     * 实现上传文件的功能 并作健壮性
     * @param $file 文件数据($_FILES['表单提交的文件名'])
     * @param $type 文件夹(文件归类/)
     * @return string 返回文件路径
     */
    public function upload($file, $type)
    {
//        Tools::myDump($file);die;
        //判断上传的文件成功
        if ($file['error'] != 0) {
//            Tools::jump("?c=Brand&a=edit&id={$file['id']}", '文件上传出错!(error!=0)', 3);
            $this->error = '文件上传出错!(error!=0)';
            return false;
        }
        //判断上传的文件后缀  不过此 MIME 类型在 PHP 端并不检查
        $allow = ['image/gif', 'image/jpg', 'image/png', 'image/swf', 'image/psd', 'image/bmp', 'image/svg', 'image/psd', 'image/jpc', 'image/jp2', 'image/jpeg'];//禁止脚本文件[,'.php']
        if (!in_array($file['type'], $allow)) {
            $this->error = '文件格式不是允许的图片格式,文件后缀为小写';
            return false;
        }
        //判断图片2  判断文件为真正意义上的图片
        $size = getimagesize($file['tmp_name']);
        if ($size === false) {
            $this->error = '非法文件不允许上传';
            return false;
        }
        //判断图片3 判断是以HTTP post方式传输
        if (!is_uploaded_file($file['tmp_name'])) {
            $this->error = '图片上传方式不是通过 HTTP POST传输!';
            return false;
        }
        //判断图片超大
        if ($file['size'] > 1024 * 1024*2) { //判断文件大小,文件大小以字节来表示大小
            $this->error = '上传文件不能从超过2M!';
            return false;
        }
        //临时文件路径
        $tmp = $file['tmp_name'];
        /**自动创建上传文件的路径文件夹**/
        /**自动创建上传文件的路径文件夹**/
        $dirname = './Uploads/' . $type . date('Ymd') . '/';
        if (!is_dir($dirname)) {   //判断是否存在或这合法
            //不存在并合法就创建.0777是模式的权限..true是迭代创建
            mkdir($dirname, 0777, true);
        }
        //唯一的文件名前面添加img_
        $upload = uniqid('img_').strrchr($file['name'], '.');
        //移动到新建的路径保存,成功则返回true
        $move = @move_uploaded_file($tmp, $dirname . $upload);
        if ($move === false) {
            $this->error = '图片移动出错!!';
            return false;
        }
        //最后返回这个文件路径保存到数据库
        return $dirname.$upload;
    }
}