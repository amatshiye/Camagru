<?php

session_start();

if (isset($_GET['no_image']))
{
    echo "<script>alert('Please select a photo to upload first!')</script>";
}
else if (isset($_GET['file_error']))
{
    echo "<script>alert('Error: Image is invalid.')</script>";
}
else if (isset($_GET['format_not_supported']))
{
    echo "<script>alert('Only jpeg, jpg and png are allowed!')</script>";
}
else if (isset($_GET['file_too_large']))
{
    echo "<script>alert('File too large!!!. Try a file less than 10mb')</script>";
}
else if (isset($_GET['file_exists']))
{
    echo "<script>alert('File already exists. Try a different photo')</script>";
}
else if (isset($_GET['file_uploaded']))
{
    echo "<script>alert('File uploaded!')</script>";
}
else if (isset($_GET['file_not_found']))
{
    echo "<script>alert('Error: File not found!')</script>";
}
else if (isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_GET['login']) && $_GET['login'] == 1)
{
    echo ("<script>alert('Logged in successfully');</script>");
}
else if ($_SESSION['username'] == "" || $_SESSION['email'] == "")
{
    header("Location: login.php?user=res");
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Camera</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
          <!--Header out here-->
  <div class="topnav" id="myTopnav">
    <a href="index.php">Home</a>
    <a href="gallery.php">Gallery</a>
    <a href="settings.php">Settings</a>
    <a href="index.php?user=log">Logout</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
    <!--Stickers-->
    <div class="grid">
    <div class="row">
        <div class="column">
            <button onclick="showImage1()">
                <img id="inlove" src="stickers/inlove.png" height="100" width="auto">
            </button>
            <button onclick="#">
                <img id="joy" src="stickers/joy.png" height="100" width="auto">
            </button>
        </div>
        <div class="column">
            <button onclick="#" type="button">
                <img id="weak_smile" src="stickers/weak_smile.png" height="100" width="auto">
            </button>
            <button onclick="#">
                <img id="smile" src="stickers/smile.png" height="100" width="auto">
            </button>
        </div>
        </div>
    </div>
</div>
    <div class="pen-title">
        <h1>PixelX</h1><span> <i class='fa fa-code'></i> </span>
    </div>
    <!--Camera here DUDE!!!-->

    <form class="booth" action="config/upload.php" method="POST" enctype="multipart/form-data">
        <video class="video" id="video" width="400" height="300"></video>
        <canvas class="canvas" id="over_video" width="400" height="300"></canvas>
        <a href="#" id="capture" class="take">Take Photo!</a>
        <input type="file" name="image" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
    <div class="boot1">
        <canvas id="canvas" width="400" height="300"></canvas>
    </div>

    <!--js code!!!-->
    <script>
    
    //SUPER IMPOSING BEGINS. DAN DAN DAAAAAAN!!!!!

    var btnClick1 = false;
    var img = document.getElementById('inlove');
    var context_img1;

    function showImage1()
    {
        canvas = document.getElementById('over_video'),
        context = canvas.getContext('2d'),
        context_img1 = context;

        context.drawImage(img, 0, 0, 100, 100);
        btnClick1 = true;
    }
    
    //CAMERA STUFF BEGIN HERE
    (function()
    {
        var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');
        vendorUrl = window.URL || window.webkitURL;
        
        navigator.getMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;
        navigator.getMedia({
            video: true,
            audio: false
        }, function (stream) {
            video.src = vendorUrl.createObjectURL(stream);
            video.play();
        }, function (error) {
            alert('Error tyring to use camera');
            console.log("Camera not found!!!");
        });
        
        var clickBtn = document.getElementById('capture').addEventListener('click', function() {

            context.drawImage(video, 0, 0, 400, 300);
            context.drawImage(img, 0, 0, 100, 100);
            context_img1.clearRect(0, 0, canvas.width, canvas.height);

            var raw = canvas.toDataURL("image/png");
            document.getElementById('hidden_data').value = raw;
            var fd = new FormData(document.forms["form1"]);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'config/upload_data.php', true);
            xhr.send(fd);
            window.location.href = "localhost:8080/boom/cam.php";
        });
    })();
    //THIS IS THE END OF THE FIRST JS LINES

    </script>
    <script>
        
        //getting image path via url params
        var url  = window.location.href;
        var params = url.split("=");
        if (params[1] != null)
        {
            var file_path = "config/" + params[1];

            //displaying the image on the canvas
            var canvas = document.getElementById('canvas')
            if (canvas != null)
            {
                var context = canvas.getContext('2d');
                console.log("Getting image");
                display_image();
                function display_image()
                {
                    display_image = new Image();
                    display_image.src = file_path;
                    console.log("Image found");
                    display_image.onload = function(){
                        context.drawImage(display_image, 0, 0, 400, 300);
                        console.log("Displaying image");
                    }
                }
            }
            else
            {
                console.log("Error: Unable to display image");
            }
        }
        else
        {
            console.log("File doesn't exists or other shit went down");
        }
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
        //THE END OF THE SECOND JS LINES
        </script>
        <script>


            </script>
            <form method="POST" accept-charset="utf-8" name="form1">
                <input name="hidden_data" id="hidden_data" type="hidden"/>
                </form>
        </br>
        </br>
        </br>
                <div class="footer">
                    <p>© 2017 PixelX</p>
                </div>
            </body>
            </html>