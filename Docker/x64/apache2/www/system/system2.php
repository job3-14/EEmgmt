<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["check"]!=1){
  $errorMessages[] = "内容確認にチェックを入れてください";
}

$path = "/var/command/signalfile.py";
if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /adduser_error.php');
}else{
  if($_POST["operete"]){
    if($_POST["operete"]=="shutdown"){
      $command = "command=Shutdown";
      file_put_contents($path, $command);
    }elseif($_POST["operete"]=="restart"){
      $command = "command=Reboot";
      file_put_contents($path, $command);
    }
  }else{
    $errorMessages[] = "操作エラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
  }
}
 ?>
