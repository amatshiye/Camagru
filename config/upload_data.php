<?php

session_start();
require_once ('database.php');

$user = $_SESSION['username'];
if (!file_exists("upload"))
{
    mkdir("upload");
}
$upload_dir = "upload/";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir .$user.mktime(). ".png";


$saved_file = file_put_contents($file, $data);

$image = $file;
$image_sticker = "upload/sticker.png";

function super_impose($src, $dest, $sticker)
{
    $image_1 = imagecreatefrompng($src);
    $stamp = imagecreatefrompng($sticker);
    
    list($width, $height) = getimagesize($src);
    list($width_small, $height_small) = getimagesize($sticker);
    $marge_right = ($width / 2) - ($width_small / 2);
    $marge_bottom = ($height / 2) - ($height_small / 2);

    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    imagealphablending($image_1, true);
    imagesavealpha($image_1, true);
    imagecopy($image_1, $stamp, imagesx($image_1) - $sx - $marge_right, imagesy($image_1) - $sy - $marge_bottom, 0, 0, $width_small, $height_small);
    imagepng($image_1, $dest);
}
super_impose($image, $file, $image_sticker);

print $success ? $file : "<script>alert('Unable to save file')</script>";
?>