<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
function permission($menuName){
  try {
      $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
      $sql  = $pdo->prepare("SELECT ? FROM login WHERE username = ?");
      $sql->bindValue(1,$type);
      $sql->bindValue(2,$username);
      $sql->execute();
      $result=  $sql->fetchColumn();
  }catch (Exception $e){
    $operateErrorMessages[] = "データベース接続エラーです";
  }
}
?>
