<?php
/**
* @version 1.0
* @author   Ben
* @date 2008-1-30
* @email jinmaodao116@163.com
* @验证码文件类
* int function imagecolorallocate(resource image, int red, int green, int blue) //为一幅图像分配颜色
* bool function imagefilledrectangle(resource image, int x1, int y1, int x2, int y2, int color) //画一矩形并填充
* bool function imagerectangle(resource image, int x1, int y1, int x2, int y2, int col)   //画一个矩形
* bool function imagesetpixel(resource image, int x, int y, int color)   //画一个单一像素
*/
class ValidationCode
{
private $width,$height,$codenum;
public $checkcode;     //产生的验证码
private $checkimage;    //验证码图片
private $disturbColor = ''; //干扰像素
/*
* 参数：（宽度，高度，字符个数）
*/
function __construct($width='80',$height='20',$codenum='4')
{
   $this->width=$width;
   $this->height=$height;
   $this->codenum=$codenum;
}
function outImg()
{
    //产生验证码
   $this->createCode();
   //输出头
   $this->outFileHeader();
   

   //产生图片
   $this->createImage();
   //设置干扰像素
   $this->setDisturbColor();
   //往图片上写验证码
   $this->writeCheckCodeToImage();
   imagepng($this->checkimage);
   imagedestroy($this->checkimage);
}
/*
   * @brief 输出头
   */
private function outFileHeader()
{
   header ("Content-type: image/png");
}
/**
   * 产生验证码
   */
private function createCode()
{
   $this->checkcode = strtoupper(substr(md5(rand()),0,$this->codenum));
}
/**
   * 产生验证码图片
   */
private function createImage()
{
   $this->checkimage = @imagecreate($this->width,$this->height);
   $back = imagecolorallocate($this->checkimage,255,255,255);
   $border = imagecolorallocate($this->checkimage,0,0,0);  
   imagefilledrectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$back); // 白色底
   imagerectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$border);   // 黑色边框
}
/**
   * 设置图片的干扰像素
   */
private function setDisturbColor()
{
   for ($i=0;$i<=200;$i++)
   {
    $this->disturbColor = imagecolorallocate($this->checkimage, rand(0,255), rand(0,255), rand(0,255));
    imagesetpixel($this->checkimage,rand(2,128),rand(2,38),$this->disturbColor);
   }
}
/**
   *
   * 在验证码图片上逐个画上验证码
   *
   */
private function writeCheckCodeToImage()
{
   for ($i=0;$i<=$this->codenum;$i++)
   {
    $bg_color = imagecolorallocate ($this->checkimage, rand(0,255), rand(0,128), rand(0,255));
    $x = floor($this->width/$this->codenum)*$i;
    $y = rand(0,$this->height-15);
    imagechar ($this->checkimage, rand(5,8), $x, $y, $this->checkcode[$i], $bg_color);
   }
}
function __destruct()
{
   unset($this->width,$this->height,$this->codenum);
}
}

?>