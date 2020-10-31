<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(isset($_GET['logout'])){
    session_destroy();
    header('location: login.php');   
}