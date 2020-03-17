<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

if (isset($_SESSION['username']) AND $_SESSION['username'] != '') {



    header("location:index.php");

    exit();

}
?>
﻿<!doctype html>
<html dir="rtl">

    <head>

        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

        <title>

            تسجيل مستخدم جديد

        </title>

        <link href="style.css" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <div class="mainLayout">

            <div class="header">

                <a href="index.php"> الرئيسية </a>

                <a href="login.php"> تسجيل الدخول </a>

                <a href="signup.php"> تسجيل مستخدم جديد </a>

            </div>

            <div class="content">

                <form action="signup.php?action=submit" method="POST">

                    <table>

                        <tr>

                            <td><label> اسم المستخدم : </label></td>

                            <td><input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"></td>

                        </tr>

                        <tr>

                            <td><label>البريد الإلكتروني : </label>

                            <td><input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>

                        </tr>

                        <tr>

                            <td><label>تأكيد البريد الإلكتروني :</label>

                            <td><input type="text" name="email2" value="<?php echo isset($_POST['email2']) ? $_POST['email2'] : ''; ?>"><br>

                        </tr>

                        <tr>

                            <td><label> كلمة المرور : </label>

                            <td><input type="password" name="password"><br>

                        </tr>

                        <tr>

                            <td><label>تأكيد كلمة المرور :</label>

                            <td><input type="password" name="password2"><br>

                        </tr>

                        <tr>

                            <td colspan="2"><input type="submit" name="submit" value="  تسجيل  "></td>

                        </tr>

                    </table>

                </form>

                <?php

                // إستدعاء ملف الإتصال بقاعدة البيانات
				
                require_once('database_connect.php');



                // متغير لحفظ نصوص الأخطاء

                $error;



                if (isset($_GET['action']) and $_GET['action'] == 'submit') {

                    if (username_v() and email_v() and pass_v()) {
						
                        if (checkUser()) {

                            echo ("<h4 style='color:#FF0;'>هذا المستخدم موجود بالفعل !</h4>");

                        } else {

                            signUp();

                            echo ("<h4 style='color:#0F0;'>تم التسجيل بنجاح !</h4>");

                        }

                    } else {

                        echo "<h4 style='color:#F53;'>$error</h4>";

                    }

                }

                ?>

            </div>

            <div class="footer">

                <span > جميع الحقوق محفوظة المطور احمد علي</span><br />

            </div>

        </div>

    </body>

</html>







<!-- هنا أكواد الدوال -->



<?php



// دالة التحقق من اسم المستخدم

function username_v() {

    global $error;



    if (isset($_POST['username']) and $_POST['username'] != null) {

        if (preg_match('/^([a-zA-Z0-9._-]){6,30}$/', $_POST['username'])) {

            return true;

        } else {

            $error = "يجب أن يكون اسم المستخدم مكون من الحروف الإنجليزية الكبيرة أو الصغيرة أو الأرقام أو العلامات الخاصة . و _ و - أو خليط منهم فقط ويكون طول اسم المستخدم من 6 إلى 30 عنصر";

            return false;

        }

    } else {

        $error = "يرجى ملئ حقل اسم المستخدم";

        return false;

    }

}



// دالة التحقق من كلمة المرور

function pass_v() {

    global $error;



    if ((isset($_POST['password']) and $_POST['password'] != null)

            and (isset($_POST['password2']) and $_POST['password2'] != null)) {

        if (preg_match('/^([a-zA-Z0-9]){6,20}$/', $_POST['password'])) {

            if ($_POST['password'] != $_POST['password2']) {

                $error = "كلمة المرور غير متطابقة";

                return false;

            } else {

                return true;

            }

        } else {

            $error = "يرجى كتابة كلمة مرور تحتوي على حروف إنجليزية كبيرة أو ضغيرة أو أرقام أو خليط منهم فقط وأن يكون طول كلمة المرور من 6 إلى 20 عنصر";

            return false;

        }

    } else {

        $error = "يرجى ملئ حقول كلمة المرور";

        return false;

    }

}



// دالة التحقق من البريد الإلكتروني

function email_v() {

    global $error;



    if ((isset($_POST['email']) and $_POST['email'] != null)

            and (isset($_POST['email2']) and $_POST['email2'] != null)) {

        if (preg_match('/^([a-zA-Z])([a-zA-Z0-9._-]){2,30}@([a-zA-Z0-9.-])+\.([a-zA-Z0-9]){2,5}$/', $_POST['email'])) {

            if ($_POST['email'] != $_POST['email2']) {

                $error = "البريد الإلكتروني غير متطابق";

                return false;

            } else {

                return true;

            }

        } else {

            $error = "يرجى كتابة بريد إلكتروني صحيح";

            return false;

        }

    } else {

        $error = "يرجى ملئ حقول البريد الإلكتروني";

        return false;

    }

}



// دالة التحقق من وجود مستخدم مُسجَل مسبقاً

function checkUser() {

	global $conn_link;
	
	$query = "SELECT * FROM users WHERE user_name='{$_POST['username']}'";
	
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



// دالة تسجيل مستخدم جديد

function signUp() {

    global $conn_link;
	
	$query = "INSERT INTO users (user_name,user_pass,user_email) VALUES ('{$_POST['username']}','{$_POST['password']}','{$_POST['email']}')";
	
	if (mysqli_query($conn_link,$query) === true)
	{
		return true;
	}
	else
	{
		return false;
	}

}

require_once('database_close.php');
?>