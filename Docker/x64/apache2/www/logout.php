<?php
session_start();


$_SESSION = array();
#セッション変数を全て削除
session_destroy();
#セッションを削除

session_start();
$_SESSION["message"] = "logout";
?>
