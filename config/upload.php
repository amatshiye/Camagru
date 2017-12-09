<?php

session_start();

$dir_upload = "upload/";
if (isset($_FILES['image']))
{
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $exploded = explode('.', $file_name);
    $file_ext = strtolower(end($exploded));

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false)
    {
        header("Location: ../cam.php?format_not_supported");
        exit();
    }
    else if ($file_size > 100000000)
    {
        header("Location: ../cam.php?file_too_large");
        exit();
    }
    else
    {
        $file_path = $dir_upload.$file_name;
        if (file_exists($file_path))
        {
            header("Location: ../cam.php?file_exists");
            exit();
        }
        else
        {
            move_uploaded_file($file_tmp, $file_path);
            header("Location: ../cam.php?file_uploaded&file_path=".$file_path);
            exit();
        }
    }
}
else
{
    header("Location: ../cam.php?file_not_found");
    exit();
}

?>