<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');

function conversion($permission){
  if($permission!=1){
    return 0;
  }else{
    return 1;
  }
}

$permisson["addcard"]=conversion($_POST["addcard"]);
$permisson["editcard"]=conversion($_POST["editcard"]);
$permisson["sendnotice"]=conversion($_POST["sendnotice"]);
$permisson["viewexit"]=conversion($_POST["viewexit"]);
$permisson["viewloginlog"]=conversion($_POST["viewloginlog"]);
$permisson["deletelog"]=conversion($_POST["deletelog"]);
$permisson["initialize"]=conversion($_POST["initialize"]);
$permisson["setmail"]=conversion($_POST["setmail"]);
$permisson["shutdown"]=conversion($_POST["shutdown"]);
$permisson["edituser"]=conversion($_POST["edituser"]);


try {
  $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql=$pdo->prepare("UPDATE login SET addcard=?, editcard=?, sendnotice=?, viewexit=?, viewloginlog=?, deletelog=?, initialize=?, setmail=?, shutdown=?, edituser=? WHERE username=?");
  $sql->bindValue(1,$permisson["addcard"]);
  $sql->bindValue(2,$permisson["editcard"]);
  $sql->bindValue(3,$permisson["sendnotice"]);
  $sql->bindValue(4,$permisson["viewexit"]);
  $sql->bindValue(5,$permisson["viewloginlog"]);
  $sql->bindValue(6,$permisson["deletelog"]);
  $sql->bindValue(7,$permisson["initialize"]);
  $sql->bindValue(8,$permisson["setmail"]);
  $sql->bindValue(9,$permisson["shutdown"]);
  $sql->bindValue(10,$permisson["edituser"]);
  $sql->bindValue(11,$_POST["username"]);
  $sql->execute();
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです";
}

if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}
?>
