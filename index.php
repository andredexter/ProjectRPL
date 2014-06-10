<?php
session_start();
//$_SESSION['user']="Admin";
//$_SESSION['prive']=1;
//session_unset();
require('content/classes/mainClass.php');
$webApp = new webApp();
$webApp->createWebApp();
?>