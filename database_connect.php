﻿<?php
// مستضيف قاعدة البيانات
$database['host'] = 'localhost';
// اسم المستخدم لقاعدة البيانات
$database['username'] = 'root';
// كلمة المرور لمستخدم قاعدة البيانات
$database['userpass'] = '';
// اسم قاعدة البيانات
$database['name'] = 'flip';

// كود عمل رابط الإتصال بقاعدة البيانات
$conn_link = mysqli_connect($database['host'],$database['username'],$database['userpass'],$database['name']) or die(mysqli_connect_error());

?>