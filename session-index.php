<?
session_start();

if (!isset($_SESSION['username']) AND !isset($_SESSION['password'])) {

    header("location:login.php");

    exit();

}

?>