<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/29
 * Time: 11:20
 */

/**
 *
 * Class CaptchaController
 */
class CaptchaController
{
    //添加一个随机的字符串
    public function create1(){
        //>>1.生成随机字符串
        //准备所有需要的数字和字母
        $str = "23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        //打乱
        $str = str_shuffle($str);
        //截取指定长度
        $random_code = substr($str,mt_rand(0,28),4);
        //>>2.将随机字符串保存到session中
        @session_start();
        $_SESSION['random_code'] = $random_code;
        //>>3.将随机字符串写到图片上
        //>>1.图片的背景随机改变
        //图片路径
        $image_src = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";
        //动态的获取图片的宽高
        $imagesize = getimagesize($image_src);
        list($width,$height) = $imagesize;
        //从已经存在的图片创建画布
        $image = imagecreatefromjpeg($image_src);
        //>>2.文字颜色 随机 黑白 变换
        //>>1.选择颜色
        $white = imagecolorallocate($image,255,255,255);
        $black = imagecolorallocate($image,0,0,0);
        $color = [$white,$black];
        shuffle($color);//打乱数组
        /**
         * 混淆验证码 了解
         */
        //加点 随机位置随机颜色加多个点
        for ($i=0;$i<=200;++$i){
            //随机颜色
            $rand_color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //画点
            imagesetpixel($image,mt_rand(0,$width),mt_rand(0,$height),$rand_color);
        }
        //画线
        for ($i=0;$i<=7;++$i){
            //随机颜色
            $rand_color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //画线
            imageline($image,mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height),$rand_color);
        }

        //>>2.写字
//        imagestring($image,5,0,0,$random_code,mt_rand(0,1)?$white:$black);
        imagestring($image,5,$width/2.8,$height/8,$random_code,$color[0]);
        //>>3.白色边框
        imagerectangle($image,0,0,$width-1,$height-1,$white);
        //>>4.输出图片到浏览器
        header("Content-Type: image/jpeg");
        imagejpeg($image);
        //>>5.销毁图片
        imagedestroy($image);
    }
    public function create(){
//1.拿到一张图片随机截取图片的位置
        $imagePath = PUBLIC_PATH."Admin/captcha/source.png";                                         //1-
        //>>1.先获取图片的size
        $size = getimagesize($imagePath);
        list($width,$height) = $size;
        //>>2.期望验证码图片的宽高
        $width1=180;$height1=24;
        //>>3.截取的位置
        $x = mt_rand(0,$width-200);
        $y = mt_rand(0,$height-55);
        //直接生成一个图片
        $image = imagecreatetruecolor($width1,$height1);
        //创建一个资源图片
        $s_image = imagecreatefromjpeg($imagePath);
        //>>4.重采样拷贝部分图像并调整大小(就是截取图片的一小部分,然后放在新的资源图片里显示出来)
        imagecopyresampled($image,$s_image,0,0,$x,$y,$width1,$height1,$width1,$height1);

//4.随机码值
        $chars = "123456789";
        $chars2 = "+-*";
        $chars1 = str_shuffle($chars);

        $random[0] = substr($chars1, mt_rand(0,8),mt_rand(1,2));
        $random[2] = substr($chars2, mt_rand(0,2),1);
        $random[1] = substr($chars1, mt_rand(0,8),1);

        $math = $random[0].$random[2].$random[1].'= ?';

        @session_start();
        if ($random[2] == '+'){
            $random_code = $random[0]+$random[1];
            $_SESSION['random_code'] = $random_code;
        }
        if ($random[2] == '-'){
            $random_code = $random[0]-$random[1];
            $_SESSION['random_code'] = $random_code;
        }
        if ($random[2] == '*'){
            $random_code = $random[0]*$random[1];
            $_SESSION['random_code'] = $random_code;
        }

//5.文字颜色白黑色随机切换
        $color[0] = imagecolorallocatealpha($image,255,255,255,1);
        $color[1] = imagecolorallocate($image,0, 0, 0);

        /**
         * 混淆验证码 了解
         */
        //加点 随机位置随机颜色加多个点

        for ($i=0;$i<=200;++$i){
            //随机颜色
            $rand_color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //画点
            imagesetpixel($image,mt_rand(0,$width1),mt_rand(0,$height1),$rand_color);
        }
        //画线
        for ($i=0;$i<=7;++$i){
            //随机颜色
            $rand_color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            //画线
            imageline($image,mt_rand(0,$width1),mt_rand(0,$height1),mt_rand(0,$width1),mt_rand(0,$height1),$rand_color);
        }

//6. 将随机码写到图片上
        imagestring($image,5,$width1/2.8,$height1/8,$math,$color[mt_rand(0,1)]);

        //>>白色边框
        imagerectangle($image,0,0,$width1-1,$height1-1,$color[0]);
//7.输出图片到浏览器
        header("Content-Type: image/png");                                           //3-
//        imagegd2($image,'./1.png');
        imagepng($image);                                                                   //4-
//8.销毁创建的图片
        imagedestroy($image);
        imagedestroy($s_image);
    }
}