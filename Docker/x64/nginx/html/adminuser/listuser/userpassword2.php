<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission("edituser");
$username=$_POST["username"];
$password1=$_POST["password1"];
$password2=$_POST["password2"];

if($username==$password1){
  $errorMessages[] ="ユーザーとパスワードは一致してはいけません。違う組み合わせにしてください";
}
if($password1==""){
  $errorMessages[] = "パスワードを入力してください";
}elseif($password2){
  $errorMessages[] = "パスワードを2度入力してください";
}elseif($password1==$password2){
  $errorMessages[] = "パスワードが一致していません";
}
if(strlen($password1)<6 || strlen($password1)>=50){
  $errorMessages[] = "パスワードは6文字から50文字で入力してください。";
}
if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
}

$password=password_hash($password, PASSWORD_DEFAULT);

try {
  $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql=$pdo->prepare("UPDATE login SET pass=? WHERE username=?");
  $sql->bindValue(1,$password);
  $sql->bindValue(2,$username);
  $sql->execute();
}catch (Exception $e){
  $operateErrorMessages[]="データベース接続エラーです";
}

if(isset($operateErrorMessages)){
  $_SESSION["errorMessages"]=$operateErrorMessages;
  header('Location: /operate_error.php');
}

header('Location: ./userpassword3.php?username='.$username);
?>
