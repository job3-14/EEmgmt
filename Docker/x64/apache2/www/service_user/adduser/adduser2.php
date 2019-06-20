<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
//$errorMessages = array();

if($_POST["user"]==""){
  $errorMessages[] = "ユーザー名を入力してください";
}
if($_POST["email"]==""){
  $errorMessages[] = "メールアドレスを入力してください";
}
if($_POST["cardidm"]==""){
  $errorMessages[] = "カードidmを入力してください";
}
if($_POST["sendMethod"]==""){
  $errorMessages[] = "送信方法が指定されていません";
}

if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}else{
  $_SESSION["addcard"]["user"] = $_POST["user"];
  $_SESSION["addcard"]["email"] = $_POST["email"];
  $_SESSION["addcard"]["cardidm"] = $_POST["cardidm"];
  $_SESSION["addcard"]["sendMethod"] = $_POST["sendMethod"];
}

 ?>
