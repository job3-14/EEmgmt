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

echo conversion($_POST["editcard"]);

try {
  $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  //$sql=$pdo->prepare("INSERT INTO login (addcard,editcard,sendnotice,viewexit,viewloginlog,deletelog,initialize,setmail,shutdown,edituser) VALUES (?,?,?,?,?,?,?,?,?,?) WHERE username='".$_POST["username"]."'");
  $sql=$pdo->prepare("UPDATE login SET addcard=?, editcard=?, sendnotice=?, viewexit=?, viewloginlog=?, deletelog=?, initialize=?, setmail=?, shutdown=?, edituser=? WHERE username=?");
  $sql->bindValue(1,conversion($_POST["addcard"]));
  $sql->bindValue(2,conversion($_POST["editcard"]));
  $sql->bindValue(3,conversion($_POST["sendnotice"]));
  $sql->bindValue(4,conversion($_POST["viewexit"]));
  $sql->bindValue(5,conversion($_POST["viewloginlog"]));
  $sql->bindValue(6,conversion($_POST["deletelog"]));
  $sql->bindValue(7,conversion($_POST["initialize"]));
  $sql->bindValue(8,conversion($_POST["setmail"]));
  $sql->bindValue(9,conversion($_POST["shutdown"]));
  $sql->bindValue(10,conversion($_POST["edituser"]));
  $sql->bindValue(11,conversion($_POST["username"]));
  $sql->execute();
}catch (Exception $e){
  $errorMessages[]="データベース接続エラーです";
}

if(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}
?>
