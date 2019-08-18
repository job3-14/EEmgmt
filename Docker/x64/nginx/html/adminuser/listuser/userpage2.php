<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("edituser");

if($_POST["username"]==$_SESSION["user"] && $_POST["edituser"]!=1){
  $normalErrorMessages[] = "自身のアカウントの管理ユーザー追加,編集機能を削除することはできません";
}

function conversion($permission){
  if($permission!=1){
    return 0;
  }else{
    return 1;
  }
}

if($normalErrorMessages){
  $_SESSION["errorMessages"]=$normalErrorMessages;
  header('Location: /normal_error.php');
}elseif($errorMessages){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}else{
  $permisson["addcard"]=conversion($_POST["addcard"]);
  $permisson["editcard"]=conversion($_POST["editcard"]);
  $permisson["sendnotice"]=conversion($_POST["sendnotice"]);
  $permisson["viewexit"]=conversion($_POST["viewexit"]);
  $permisson["shutdown"]=conversion($_POST["shutdown"]);
  $permisson["edituser"]=conversion($_POST["edituser"]);

  try {
    $pdo=new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql=$pdo->prepare("UPDATE login SET addcard=?, editcard=?, sendnotice=?, viewexit=?, shutdown=?, edituser=? WHERE username=?");
    $sql->bindValue(1,$permisson["addcard"]);
    $sql->bindValue(2,$permisson["editcard"]);
    $sql->bindValue(3,$permisson["sendnotice"]);
    $sql->bindValue(4,$permisson["viewexit"]);
    $sql->bindValue(5,$permisson["shutdown"]);
    $sql->bindValue(6,$permisson["edituser"]);
    $sql->bindValue(7,$_POST["username"]);
    $sql->execute();
  }catch (Exception $e){
    $errorMessages[]="データベース接続エラーです";
  }
  header('Location: ./userpage3.php?username='.$_POST["username"]);
}
?>
