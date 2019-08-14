<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if(!$_POST["password"]){
  $errorMessages[] = "パスワードを入力してください";
}elseif(strlen($_POST["password"])<6 || strlen($_POST["password"])>=50){
  $errorMessages[] = "パスワードは6文字から50文字で入力してください";
}

if($errorMessages){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
}else{
  $_SESSION["addcard"]["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
  header('Location: ./adduser5_line.php');
}
?>
