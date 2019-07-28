<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
$name = $_POST["name"];

if(!$_POST["password"]){
  $errorMessages[] = "パスワードを入力してください";
}elseif(strlen($_POST["password"])<6 || strlen($_POST["password"])>=50){
  $errorMessages[] = "パスワードは6文字から50文字で入力してください";
}

if($errorMessages){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./normal_error.php');
}

$password=password_hash($_POST["password"], PASSWORD_DEFAULT);

try {
  $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql=$pdo->prepare("UPDATE service_user SET password=? WHERE name=?");
  $sql->bindValue(1,$password);
  $sql->bindValue(2,$name);
  $sql->execute();
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです";
}

if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

header('Location: ./userpassword3.php?name='.$name);
?>
