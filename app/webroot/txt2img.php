<?php
if(!isset($_GET['text']))
{ 
exit(); 
}

header ("Content-type: image/png");
$string = $_GET['text'];                                            
$font   = 4;
$width  = ImageFontWidth($font) * strlen($string);
$height = ImageFontHeight($font);

$im = @imagecreate ($width,$height);
$background_color = imagecolorallocate ($im, 255, 255, 255); //white background
$text_color = imagecolorallocate ($im, 0, 0,0);//black text
imagestring ($im, $font, 0, 0,  $string, $text_color);
imagepng ($im);
?>