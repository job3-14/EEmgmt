<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["slack1"] && !filter_var($_POST["slack1"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}elseif($_POST["slack2"] && !filter_var($_POST["slack2"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}elseif($_POST["slack3"] && !filter_var($_POST["slack3"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}elseif($_POST["slack4"] && !filter_var($_POST["slack4"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}elseif($_POST["slack5"] && !filter_var($_POST["slack5"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}

if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}else{
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
  $_SESSION["addcard"]["emaiList"] = $mailList;
  header('Location: ./adduser5_slack.php');
}
?>
