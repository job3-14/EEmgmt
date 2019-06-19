<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$errorMessages = array();

if($_POST["user"]=="" || $_POST["email"]=="" || $_POST["cardidm"]=="" || $_POST["sendMethod"]==""){
  echo "error";
}else{
  echo "hello!";
}

$_SESSION["addcard"]["user"] = $_POST["user"];
$_SESSION["addcard"]["email"] = $_POST["email"];
$_SESSION["addcard"]["cardidm"] = $_POST["cardidm"];
$_SESSION["addcard"]["sendMethod"] = $_POST["sendMethod"];


 ?>
