<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["password"]=="" || !isset($_POST["password"])){
  $errorMessages[] = "パスワードを入力してください";
}

if(!$errorMessages){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}else{
  $_SESSION["addcard"]["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
  header('Location: ./adduser5.php');
}
?>
