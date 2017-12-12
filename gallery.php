<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Gallery</title>
</head>
<body>
      <!--Header out here-->
  <div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="gallery.php">Gallery</a>
    <a href="settings.php">Settings</a>
    <a class="log" href="login.php?user=log">Logout</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>

    <script>
    //Header 
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

          function loadnew() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
              }
            };
            location.href = "gallery.php?num";
            xhttp.open("GET", "gallery.php?num", true);
            xhttp.send();
          }
          //Create a form where you can reload images
          //Use ajax to reload the page
    </script>

<div class="footer">
          <p>© 2017 PixelX</p>
</div>
    </body>
    </html>

<?php

require_once ("config/database.php");

//Getting image names from the database

try
{
  //connection
  $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Select from pictures using type.
  $stmt = $conn->prepare("SELECT * FROM pictures WHERE type = :type");
  $stmt->execute(array(':type' => "image"));

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if (count($result))
  {
    foreach ($result as $row)
    {
      echo "config/".$row['name'];
      echo "<br>";
    }
  }
  else
  {
    echo "<script>alert('No posts exists!')</script>";
  }
}
catch(PDOException $e)
{
  echo "<script>alert('Unable to get images from the database')</script>";
  exit();
}
?>