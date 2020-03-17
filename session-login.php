<?
session_start();

if (isset($_SESSION['username']) AND $_SESSION['username'] != '') {



    header("location:index.php");

    exit();

}

?>