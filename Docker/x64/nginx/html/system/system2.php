<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("shutdown");
if($_POST["check"]!=1){
  $errorMessages[] = "内容確認にチェックを入れてください";
}

$path = "/var/command/signalfile.py";
if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
  exit;
}else{
  if($_POST["operete"]){
    if($_POST["operete"]=="shutdown"){
      $command = "command='Shutdown'";
      file_put_contents($path, $command);
      header('Location: /index.php');
      exit;
    }elseif($_POST["operete"]=="restart"){
      $command = "command='Reboot'";
      file_put_contents($path, $command);
      header('Location: /index.php');
      exit;
    }
  }else{
    $errorMessages[] = "操作エラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
    exit;
  }
}
 ?>
