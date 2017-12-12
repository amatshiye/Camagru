<?php 

session_start();
require_once ('database.php');

if (isset($_POST['submit']) && isset($_POST['passwd']))
{
    $passwd = $_POST['passwd'];

    if ($passwd == "")
    {
        header("Location: ../settings.php?pass");
        exit();
    }
    else
    {
        //Checking if the password if correct
        $current_username = $_SESSION['username'];
        $current_email = $_SESSION['email'];

        try
        {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
            $stmt->execute(array(':username' => $current_username));
            
            $result = $stmt->fetchAll();
            if (count($result))
            {
                foreach ($result as $row)
                {
                    $data_passwd = $row['passwd'];
                    if (password_verify($passwd, $data_passwd))
                    {
                        $pass = 1;
                    }
                    else
                    {
                        header("Location: ../settings.php?pass_incorrect");
                        exit();
                    }
                }
            }
            else
            {
                header("Location: ../settings.php?unable_to_connect");
                exit();
            }
        }
        catch(PDOException $e)
        {
            header("Location: ../settings.php?server_error");
            exit();
        }

        //checking if both fields are empty
        $username = $_POST['user_name'];
        $email = $_POST['email'];

        if ($username == "" && $email == "")
        {
            header("Location: ../config/settings.php?empty");
            exit();
        }
        else
        {
            //Connecting to database to check the user
            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
                $stmt->execute(array(':username' => $current_username));

                $result = $stmt->fetchAll();
                if (count($result))
                {
                    foreach ($result as $row)
                    {
                        //if one is empty it get's replaced by the one in the current session
                        if (empty($username))
                        {
                            $username = $row['user_name'];
                        }
                        else if (empty($email))
                        {
                            $email = $row['email'];
                        }
                    }
                    
                    //UPDATING USER INFO
                    try
                    {
                        //connecting to database to update info
                        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $stmt = $conn->prepare("UPDATE users SET user_name = :username, email = :email WHERE email = :email");
                        $stmt->execute(array(':username' => $username, ':email' => $email, ':email' => $current_email));

                        //Sending email
                        $to = $current_email;
                        $subject = "Account Updated Successfully";
                        $msg = "Your account info has been updated!";
                        $headers = 'From: noreply@pixelx.com';
                        mail($to, $subject, $msg, $headers);

                        //Updating the session variables
                        session_destroy();
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;

                        //success url message
                        header("Location: ../settings.php?success");
                        exit();
                    }
                    catch(PDOException $e)
                    {
                        header("Location: ../settings.php?server_error");
                        exit();
                    }
                }
                else
                {
                    header("Location: ../settings.php?user_not_found");
                    exit();
                }

            }
            catch(PDOException $e)
            {
                header("Location: ../settings.php?server_error");
                exit();
            }
        }
    }
}
else
{
    echo "<script>alert('Boooom yoooow')</script>";
    header("Location: ../settings.php?pass");
    exit();
}

?>