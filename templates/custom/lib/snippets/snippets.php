Создание скриншота сайта

<?php
function screen($url, $razr, $razm, $form)
{
$toapi="http://mini.s-shot.ru/".$razr."/".$razm."/".$form."/?".$url;
$scim=file_get_contents($toapi);
file_put_contents("screen.".$form, $scim);
}
screen("http://sitear.ru", "1024x768", "600", "jpeg");
?>


Функция защиты от XSS

function antihack(&$var){  
if(is_array($var)) array_walk($var, 'antihack');  
else $var = htmlspecialchars(stripslashes(mysql_real_escape_string($var)), ENT_QUOTES, 'UTF-8');  
}  
foreach(array('_SERVER', '_GET', '_POST', '_COOKIE', '_REQUEST') as $v){  
if(!empty(${$v})) array_walk(${$v}, 'antihack');  
}

Копирайт на картинку

<?php  
$img = $_GET['img']; /// путь к картинке которую копирайтим  
$im = imagecreatefromjpeg($img);   
$lg = imagecreatefrompng('copyrite.png'); /// наша картинка копирайта  
$img_x = imagesx($im);  
$img_y = imagesy($im);  
$img_x_copy = imagesx($lg);  
$img_y_copy = imagesy($lg);  
imagecopy($im, $lg, $img_x-$img_x_copy, $img_y-$img_y_copy, 0, 0, $img_x_copy, $img_y_copy);   
header('Content-Type: image/jpeg');    
imagejpeg($im);    
imagedestroy($im); /// чистиммусор  
imagedestroy($lg); /// чистим мусор  
?>

