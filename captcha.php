<?php
session_start();

// Fonction pour générer le CAPTCHA
function generateCaptcha()
{
    $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ#$*+%=?/"), 0, 6);
    $_SESSION['captcha'] = $code;
    return $code;
}

// Création de l'image CAPTCHA
$captcha_code = generateCaptcha();
$font = __DIR__ . '/fonts/Monoton-Regular.ttf'; // S'Assurer que c'est un fichier de police .ttf à cet endroit
$image = imagecreatetruecolor(200, 50);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 20, 20, 20);

imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
imagettftext($image, 20, 0, 30, 35, $text_color, $font, $captcha_code);

// Affichage de l'image CAPTCHA
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>