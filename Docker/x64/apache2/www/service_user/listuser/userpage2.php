<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
$name=$_POST["name"];
$method=$_POST["sendMethod"];

try {
  if(!$_POST["user"]==""){
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT EXISTS(SELECT idm FROM service_user WHERE idm = ?)");
    $sql->bindValue(1,$_POST["cardidm"]);
    $sql->execute();
    $result=$sql->fetchColumn();
  }
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

if($result==1){
  $errorMessages[] = "このカードは既に登録されています";
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

if($method=="email"){
  if($_POST["address2"] && !filter_var($_POST["address2"], FILTER_VALIDATE_EMAIL)){
    $errorMessages[] = "メールアドレスを正しく入力してください";
  }elseif($_POST["address3"] && !filter_var($_POST["address3"], FILTER_VALIDATE_EMAIL)){
    $errorMessages[] = "メールアドレスを正しく入力してください";
  }elseif($_POST["address4"] && !filter_var($_POST["address4"], FILTER_VALIDATE_EMAIL)){
    $errorMessages[] = "メールアドレスを正しく入力してください";
  }elseif($_POST["address5"] && !filter_var($_POST["address5"], FILTER_VALIDATE_EMAIL)){
    $errorMessages[] = "メールアドレスを正しく入力してください";
  }


    $mailList[] = $_SESSION["addcard"]["email"];
    if($_POST["email2"]){
      $mailList[] = $_POST["email2"];
    }
    if($_POST["email3"]){
      $mailList[] = $_POST["email3"];
    }
    if($_POST["email4"]){
      $mailList[] = $_POST["email4"];
    }
    if($_POST["email5"]){
      $mailList[] = $_POST["email5"];
    }
    $mailList = array_unique($mailList); //重複削除
  }

try {
  $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
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
  $operateErrorMessages[]="データベース接続エラーです";
}

if(isset($operateErrorMessages)){
  $_SESSION["errorMessages"]=$operateErrorMessages;
  header('Location: /operate_error.php');
}elseif(isset($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
}else{
  if($method=="email"){
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql=$pdo->prepare("UPDATE service_user SET mainEmail=?,idm=?,notice=?,address1=?,address2=?,address3=?,address4=?,address5=? WHERE name=?");
    $sql->bindValue(1,$_POST["email"]);
    $sql->bindValue(2,$_POST["cardidm"]);
    $sql->bindValue(3,$_POST["sendMethod"]);
    $sql->bindValue(4,$_POST["email"]);
    for($i=0,$i2=5;$i<=4;$i++,$i2++){
      if($_SESSION["addcard"]["emaiList"][$i]){
        $sql->bindValue($i2,$_POST["address".$i]);
      }else{
        $sql->bindValue($i2,null,PDO::PARAM_NULL);
      }
    }
    $sql->bindValue(9,$name);
    $sql->execute();
  }
  header('Location: ./userpage3.php?name='.$name);
}
?>
