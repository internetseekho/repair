<?php 
session_start();
unset($_SESSION['is_contractor']);
unset($_SESSION['contractor_username']);
header('location: index.php');
exit();
?>