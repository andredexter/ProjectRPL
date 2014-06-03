<?php
session_start();
//$_SESSION['user']="Admin";
//$_SESSION['prive']=1;
//session_unset();
$function='content/classes/mainClass.php';
require($function);
$webApp = new webApp();
$webApp->createWebApp();
?>