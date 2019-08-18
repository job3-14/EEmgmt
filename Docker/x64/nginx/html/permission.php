<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

function permission($type){
  include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
  try {
      $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
      $sql  = $pdo->prepare("SELECT ".$type." FROM login WHERE username = ?");
      #$sql->bindValue(1,$type);
      $sql->bindValue(1,$_SESSION["user"]);
      $sql->execute();
      $result = $sql->fetchAll();
  }catch (Exception $e){
    $operateErrorMessages[] = "データベース接続エラーです";
  }
  if ($result[0][$type] != 1){
    $operateErrorMessages[] = "権限がありません。詳細は管理者に問い合わせください。";
    $_SESSION["errorMessages"]=$operateErrorMessages;
    header('Location: /operate_error.php');
}
}

?>
