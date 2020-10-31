<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!isset($_SESSION['msg']) && $_SESSION['msg'] != "You are logged in"){
    $_SESSION['msg'] = "Please login!";
    header('location: login.php');      
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION['msg'])){ ?>
            <h2><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></h2>
    <?php
        }
    ?>
    Welcome!!

    <br><br>
    <p><a href="logout.php?logout='yes'">Logout</p>
</body>
</html>