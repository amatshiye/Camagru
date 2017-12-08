<?php

session_start();
require_once ('database.php');

$user = $_SESSION['email'];
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

//uploading file name to database
try
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Preparing query
    $stmt = $conn->prepare("INSERT INTO pictures (name, type, user, ext)
    VALUES(:name, :type, :user, :ext)");
    //Executing query
    $stmt->execute(array(':name' => $file, ':type' => "image", ':user' => $user, ':ext' => "png"));
}
catch(PDOException $e)
{
    echo "<script>alert('Error: Unable to save picture')</script>";
}
/*$success = file_put_contents($file, $data);
print $success ? $file : 'Unable to save the file.';*/
?>