<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$errorMessages = array();


$_SESSION["addcard"]["user"] = $_POST["user"];
$_SESSION["addcard"]["email"] = $_POST["email"];
$_SESSION["addcard"]["cardidm"] = $_POST["cardidm"];
$_SESSION["addcard"]["sendMethod"] = $_POST["sendMethod"];


 ?>
