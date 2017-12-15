<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Photos</title>
      <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!--Header out here-->
  <div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="gallery.php">Gallery</a>
    <a class="log" href="index.php?user=log">Logout</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>

    <script>
    function myFunction()
    {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") 
      {
        x.className += " responsive";
        } 
        else 
        {
          x.className = "topnav";
          }
          }
</script>
<div class="pen-title">
    <h1>PixelX</h1><span> <i class='fa fa-code'></i> </span>
</div>

<div class="container2">
    <?php
    session_start();

    $user = $_SESSION['username'];
    $dir = "config/upload/".$user."/*.*";
    $files_uo = glob($dir);
    $files = array_reverse($files_uo);

    for ($i = 0; $i < count($files); $i++)
    {   
        $num = $files[$i];
        $exploded = end(explode("/", $num));
        $new_dir = "config/upload/".$exploded;
        echo "<form class='form4' method='POST'>
        <img id='display' src='".$num."' alt='image file' />
        <button formaction='config/delete.php?picname=".$new_dir."&user_dir=".$num."&filename=".$exploded."' type='submit' name='delete'>Delete</button>
        </form>";
    }
    ?>
</div>

<div class="footer">
          <p>© 2017 PixelX</p>
</div>