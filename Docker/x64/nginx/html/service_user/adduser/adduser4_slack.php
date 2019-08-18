<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
exit;
}

include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("addcard");

if($_POST["slack1"] && !filter_var($_POST["slack1"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを入力してください";
}elseif($_POST["slack2"] && !filter_var($_POST["slack2"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを正しく入力してください";
}elseif($_POST["slack3"] && !filter_var($_POST["slack3"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを正しく入力してください";
}elseif($_POST["slack4"] && !filter_var($_POST["slack4"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを正しく入力してください";
}elseif($_POST["slack5"] && !filter_var($_POST["slack5"], FILTER_VALIDATE_URL)){
  $errorMessages[] = "URLを正しく入力してください";
}

if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /normal_error.php');
  exit;
}else{
  $mailList[] = $_POST["slack1"];
  if($_POST["slack2"]){
    $mailList[] = $_POST["slack2"];
  }
  if($_POST["slack3"]){
    $mailList[] = $_POST["slack3"];
  }
  if($_POST["slack4"]){
    $mailList[] = $_POST["slack4"];
  }
  if($_POST["slack5"]){
    $mailList[] = $_POST["slack5"];
  }
  $mailList = array_unique($mailList); //重複削除
  $_SESSION["addcard"]["slackList"] = $mailList;
  header('Location: ./adduser5_slack.php');
  exit;
}
?>
