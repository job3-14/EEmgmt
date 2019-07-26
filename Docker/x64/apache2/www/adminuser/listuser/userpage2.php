<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');

try {
  if(!$_POST["user"]==""){
    $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql=$pdo->prepare("SELECT EXISTS(SELECT username FROM login WHERE username = ?)");
    $sql->bindValue(1,$_POST["user"]);
    $sql->execute();
    $result=$sql->fetchColumn();
  }
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです"
}

if (isset($_POST["user"])){
  if($_POST["user"]==""){
    $errorMessages[] = "ユーザー名を入力してください";
  }
  if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["user"]) && !$_POST["user"]==""){
    $errorMessages[] = "ユーザー名は半角文字数字のみが使用できます";
  }
  if($result==1){
    $errorMessages[] = "このユーザー名は既に使用されている為使えません。別のユーザー名をご利用ください";
  }
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}else{
  $errorMessages[] = "操作エラーです";
}

if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

try {
  $sql=$pdo->prepare("INSERT INTO login (username,addcard,editcard,sendnotice,viewexit,viewloginlog,deletelog,initialize,setmail,shutdown,edituser) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);");
  $sql->bindValue(1,$_POST["adduser"]);
  $sql->bindValue(2,$_POST["addcard"]);
  $sql->bindValue(3,$_POST["editcard"]);
  $sql->bindValue(4,$_POST["sendnotice"]);
  $sql->bindValue(5,$_POST["viewexit"]);
  $sql->bindValue(6,$_POST["viewloginlog"]);
  $sql->bindValue(7,$_POST["deletelog"]);
  $sql->bindValue(8,$_POST["initialize"]);
  $sql->bindValue(9,$_POST["setmail"]);
  $sql->bindValue(10,$_POST["shutdown"]);
  $sql->bindValue(11,$_POST["edituser"]);
  $sql->execute();
  }
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです"
}
?>
