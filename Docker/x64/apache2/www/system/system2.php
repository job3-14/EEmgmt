<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["check"]!=1){
  echo "ERROR内容確認にチェックを入れてください";
}

if($_POST["operete"]){
  if($_POST["operete"]=="shutdown"){
    echo "shutdown";
  }elseif($_POST["operete"]=="restart"){
    echo "restart";
  }elseif($_POST["operete"]=="initialize"){
    echo "initialize";
  }
}else{
  echo "error!!!";
}
 ?>
