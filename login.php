﻿<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_SESSION['username']) AND $_SESSION['username'] != '') {



    header("location:index.php");

    exit();

}

?>    

<!DOCTYPE html>

<html dir="rtl">

    <head>

        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">



        <title>

            تسجيل الدخول

        </title>

        <link href="style.css" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <div class="mainLayout">

            <div class="header">

                <a href="../index.php"> الرئيسية </a>

                <a href="login.php"> تسجيل الدخول </a>

                <a href="signup.php"> تسجيل مستخدم جديد </a>

            </div>

            <div class="content">

                <form action="login.php?action=submit" method="POST">

                    <table>

                        <tr>

                            <td><label> اسم المستخدم : </label></td>

                            <td><input type="text" name="username"></td>

                        </tr>

                        <tr>

                            <td><label> كلمة المرور : </label>

                            <td><input type="text" name="password"><br>

                        </tr>

                        <tr>

                            <td colspan="2"><input type="submit" name="submit" value="تسجيل الدخول"></td>

                        </tr>

                    </table>

                </form>

                <?php

                if (isset($_GET['action']) and $_GET['action'] == 'submit') {

                    if (isset($_POST['username']) and $_POST['username'] != null and isset($_POST['password']) and $_POST['password'] != null) {
					
						// إستدعاء ملف الإتصال بقاعدة البيانات
						
						require_once('database_connect.php');
						
                        $username = preg_replace('/[^a-zA-Z0-9._-]/', '', $_POST['username']);

                        $password = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['password']);

                        if (login($username, $password)) {

                            echo "<h3 style='color:#0F0;'> تم تسجيل الدخول مرحباً بك $username<h3>";

                            $_SESSION['username'] = $username;

                            echo "<h5 style='color:#0F0;'> جاري تحويلك للصفحة الرئيسية ... <h5>";

                            echo '

                            <script type="text/javascript">

                                setTimeout(function () {

                                   window.location.href = "index.php";

                                }, 2000);

                            </script>

                            ';

                        } else {

                            echo "<h3 style='color:#F33;'> لم تتم عملية تسجيل الدخول حاول مجدداً <h3>";

                        }

                    } else {

                        echo "<h3 style='color:#F33;'>يرجى ملئ جميع الحقول</h3>";

                    }

                }

                ?>

            </div>

            <div class="footer">

                <span > جميع الحقوق محفوظة لموقع كذا وكذا</span><br />

            </div>

        </div>

    </body>

</html>







<!-- هنا أكواد الدوال -->

<?php



function login($username, $password) {

	global $conn_link;
	
	$query = "SELECT * FROM users   WHERE user_name='$username' and user_pass='$password'";
	
	if ($result = mysqli_query($conn_link,$query))
	{
		if(mysqli_num_rows($result) == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

require_once('database_close.php');
?>