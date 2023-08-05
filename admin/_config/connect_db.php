<?php
ob_start();
session_start();

$host = 'shareddb-v.hosting.stackcp.net';
$db_user = 'new-repair5-313437c391';
$db_password = 'uyq6wuxy0t';
$db_name = 'new-repair5-313437c391';

$db = mysqli_connect($host,$db_user,$db_password,$db_name) or die('Unable to connect to the database');
mysqli_query($db,"SET sql_mode='NO_ENGINE_SUBSTITUTION'");
?>