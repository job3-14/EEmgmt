<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission("sendnotice");
$idm = $_POST["idm"];

try {
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare("SELECT * FROM service_user WHERE idm=?");
    $sql->bindValue(1,$idm);
    $sql->execute();
    $user = $sql->fetchAll();
}catch (Exception $e){
  $operateErrorMessages[] = "データベース接続エラーです";
}

$data = date("Y-m-d H:i"); #日時取得
try {
  $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql  = $pdo->prepare("INSERT INTO history (idm,type,date) VALUES (?,?,?)");
  $sql->bindValue(1,$idm);
  $sql->bindValue(2,"入室");
  $sql->bindValue(3,$data);
  $sql->execute();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

try {
  $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
  $sql = $pdo->prepare("DELETE FROM history  WHERE date NOT IN (SELECT * FROM (SELECT date FROM history ORDER BY date DESC LIMIT 3000) AS v)");
  $sql->execute();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
}

if($user[0]["notice"]=="slack"){
  $jsonList=array("method"=>"slack");
  if($user[0]["address1"]){
    $jsonList["address1"]=$user[0]["address1"];
  }
  if($user[0]["address2"]){
    $jsonList["address2"]=$user[0]["address2"];
  }
  if($user[0]["address3"]){
    $jsonList["address3"]=$user[0]["address3"];
  }
  if($user[0]["address4"]){
    $jsonList["address4"]=$user[0]["address4"];
  }
  if($user[0]["address5"]){
    $jsonList["address5"]=$user[0]["address5"];
  }
}

if($user[0]["notice"]=="email"){
  $jsonList=array("method"=>"email");
  $jsonList["subject"]="入室通知";
  $jsonList["fromEmail"]=getenv("FROM_EMAIL");
  $jsonList["mailUserid"]=getenv("ID_EMAIL");
  $jsonList["mailPassword"]=getenv("PASS_EMAIL");
  if($user[0]["address1"]){
    $jsonList["address1"]=$user[0]["address1"];
  }
  if($user[0]["address2"]){
    $jsonList["address2"]=$user[0]["address2"];
  }
  if($user[0]["address3"]){
    $jsonList["address3"]=$user[0]["address3"];
  }
  if($user[0]["address4"]){
    $jsonList["address4"]=$user[0]["address4"];
  }
  if($user[0]["address5"]){
    $jsonList["address5"]=$user[0]["address5"];
  }
}

if($user[0]["notice"]=="line"){
  $jsonList=array("method"=>"line");
  $jsonList["lineToken"]=getenv("LINEAPI_TOKEN");
  $jsonList["userid"]=$user[0]["address1"];
}

$data = date("m月d日H時i分"); #日時取得
$jsonList["text"]=$user[0]["name"]."さんが".$data."に入室しました。";
$data=json_encode($jsonList,JSON_UNESCAPED_UNICODE);
$url="http://messages:5000/sendMessage";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
curl_close($ch);

header('Location: ./done.php?idm='.$idm);
?>
