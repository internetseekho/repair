<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

unset($_SESSION['login_user']);
unset($_SESSION['user_id']);
unset($_SESSION['facebook_data']);

setRedirect(SITE_URL);
exit();
?>