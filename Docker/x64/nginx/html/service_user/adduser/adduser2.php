<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("addcard");
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
try {
  if(!$_POST["user"]==""){
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT idm FROM service_user WHERE idm = ?)");
    $sql->bindValue(1,$_POST["cardidm"]);
    $sql->execute();
    $result=  $sql->fetchColumn();
  }
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

if($result==1){
  $errorMessages[] = "このカードは既に登録されています";
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
  header('Location: /normal_error.php');
  exit;
}else{
  $_SESSION["addcard"]["user"] = $_POST["user"];
  $_SESSION["addcard"]["email"] = $_POST["email"];
  $_SESSION["addcard"]["cardidm"] = $_POST["cardidm"];
  $_SESSION["addcard"]["sendMethod"] = $_POST["sendMethod"];
  $_SESSION["adduser2_status"] = 1;
  if($_POST["sendMethod"]=="email"){
    header('Location: ./adduser3_email.php');
    exit;
  }elseif($_POST["sendMethod"]=="line"){
    header('Location: ./adduser3_line.php');
    exit;
  }elseif($_POST["sendMethod"]=="slack"){
    header('Location: ./adduser3_slack.php');
    exit;
  }elseif($_POST["sendMethod"]=="none"){
    $_SESSION["addcard"]["sendMethod2"] = "なし";
    header('Location: ./adduser3_null.php');
    exit;
  }
}

 ?>
