<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["user"]==""){
  $errorMessages[] = "ユーザー名を入力してください";
}
if($_POST["email"]==""){
  $errorMessages[] = "メールアドレスを入力してください";
}elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
  $errorMessages[] = "メールアドレスを正しく入力してください";
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
  if($_POST["sendMethod"]=="email"){
    header('Location: ./adduser3_email.php');
  }elseif($_POST["sendMethod"]=="line"){
    header('Location: ./adduser3_line.php');
  }elseif($_POST["sendMethod"]=="slack"){
    header('Location: ./adduser3_slack.php');
  }elseif($_POST["sendMethod"]=="none"){
    header('Location: ./adduser4.php');
  }
}

 ?>
