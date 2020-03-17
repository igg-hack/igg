<?php
header('Content-type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['username']) AND !isset($_SESSION['password'])) {

    header("location:login.php");

    exit();

}

?>

<!DOCTYPE html>

<html dir="rtl">

    <head>

        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

        <title>

            الصفحة الرئيسية

        </title>

        <link href="style.css" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <div class="mainLayout">

            <div class="header">

                <a href="logout.php">تسجيل خروج</a>

            </div>

            <div class="content">

                <h3> مرحباً بك في الصفحة الرئيسية

                    <?php

                    echo$_SESSION['username'];

                    ?>

                </h3>

            </div>

            <div class="footer">

                <span > حقوق كذا وكذا محفوظة لشركة كذا وكذا :) </span><br />

            </div>

        </div>

    </body>

</html>