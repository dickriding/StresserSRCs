<?php
session_start();
olustur();
$_SESSION['korumakod'] = $pass;
exit();
function olustur()
{
    $md5 = md5(rand(0,999)); 
    global $pass;
	$pass = substr($md5, 10, 5);
    $width = 100;
    $height = 38; 
    $image = ImageCreate($width, $height); 
    $renk1 = ImageColorAllocate($image, 255, 255, 255);
    $renk2 = ImageColorAllocate($image, 0, 0, 0);
    $renk3 = ImageColorAllocate($image, 244, 55, 0);
    ImageFill($image, 0, 0, $renk1);
    ImageString($image, 5, 30, 4, $pass, $renk2);
    imageline($image, 0, $height/2, $width, $height/2, $renk3);
    imageline($image, $width/2, 0, $width/2, $height, $renk3); 
    header("Content-Type: image/jpeg"); 
    ImageJpeg($image);
    ImageDestroy($image);
} 
?>