<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/1
 * Time: 17:50
 */

class ImageTool
{
    private $error;
    public function getError(){
        return $this->error;
    }

    /**
     * 根据源图片创建微略图并保存到同级目录下
     * @param $s_filename 源文件路径
     * @param $width 微略图的宽
     * @param $height 微略图的高
     * @return bool|string 创建成功返回微略图路径,失败返回false
     */
    public function thumb($s_filename,$width,$height){
        //先检测源文件路径为合法文件
        if (!is_file($s_filename)){
            $this->error = '源文件路径不正确或者文件不存在';
            return false;
        }
        //获取图片的size
        $size = getimagesize($s_filename);
        list($s_width,$s_height) = $size;
        //计算出缩放的最大比例
        $scale = max($s_width/$width,$s_height/$height);
        //根据缩放比例 将 原图压缩 >> 计算出原图压缩后的大小
        $thumb_width = $s_width/$scale;
        $thumb_height = $s_height/$scale;

        //文件的mime类型=mime_content_type(文件地址) 或者下面的 $size['mime'] 为: 例image/jpeg
        $suffix = explode('/',$size['mime'])[1];
        //变量函数 2个  创建源图片资源 ,和 保存图片资源
        $createimage = 'imagecreatefrom'.$suffix;
        $save = 'image'.$suffix;
        //源图片
        $s_image = $createimage($s_filename);
        //目标图片
        $d_image = imagecreatetruecolor($width,$height);
        //1.1 设置白色背景
        $white = imagecolorallocate($d_image,255,255,255);
        imagefill($d_image,0,0,$white);
        //微略图
        imagecopyresampled($d_image,$s_image,($width-$thumb_width)/2,($height-$thumb_height)/2,0,0,$thumb_width,$thumb_height,$s_width,$s_height);

        //3. 保存目标图片(或者 发送浏览器)
            //路径信息.详情查阅手册
            $pathinfo = pathinfo($s_filename);
            //拼成源文件路径 在名字后面加上 缩略图宽高并保存到源文件同一目录下
        $thumb_file = $pathinfo['dirname'].'/'.$pathinfo['filename']."_{$width}x{$height}.".$pathinfo['extension'];
        $save($d_image,$thumb_file);
//        header('Content-Type: image/$suffix;charset=utf-8');
        imagedestroy($s_image);
        imagedestroy($d_image);
        if (!is_file($thumb_file)){
            $this->error = '缩略图创建失败!';
            return false;
        }
        return $thumb_file;
    }
}