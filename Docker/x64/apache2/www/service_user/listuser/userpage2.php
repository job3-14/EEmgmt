<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
$name = $_POST["name"];

try {
  $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql=$pdo->prepare("UPDATE service_user SET mainEmail=?,idm=?,notice=?,address1=?,address2=?,address3=?,address4=?,address5=? WHERE name=?");
  $sql->bindValue(1,$_POST["email"]);
  $sql->bindValue(2,$_POST["cardidm"]);
  $sql->bindValue(3,$_POST["sendMethod"]);
  if($_POST["sendMethod"]=="email"){
    $sql->bindValue(4,$_POST["email"]);
  }else{
    $sql->bindValue(4,$_POST["address1"]);
  }
  $sql->bindValue(5,$_POST["address2"]);
  $sql->bindValue(6,$_POST["address3"]);
  $sql->bindValue(7,$_POST["address4"]);
  $sql->bindValue(8,$_POST["address5"]);
  $sql->bindValue(9,$name);
  $sql->execute();
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです";
}

if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

header('Location: ./userpage3.php?name='.$name);
?>
