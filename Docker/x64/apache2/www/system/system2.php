<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["check"]!=1){
  $errorMessages[] = "内容確認にチェックを入れてください";
}

if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /adduser_error.php');
}else{
  if($_POST["operete"]){
    if($_POST["operete"]=="shutdown"){
      echo "shutdown";
    }elseif($_POST["operete"]=="restart"){
      echo "restart";
    }elseif($_POST["operete"]=="initialize"){
      echo "initialize";
    }
  }else{
    $errorMessages[] = "操作エラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
  }
}
 ?>
