<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

if($_POST["email2"] && !filter_var($_POST["email2"], FILTER_VALIDATE_EMAIL)){
  $errorMessages[] = "メールアドレスを正しく入力してください";
}elseif($_POST["email3"] && !filter_var($_POST["email3"], FILTER_VALIDATE_EMAIL)){
  $errorMessages[] = "メールアドレスを正しく入力してください";
}elseif($_POST["email4"] && !filter_var($_POST["email4"], FILTER_VALIDATE_EMAIL)){
  $errorMessages[] = "メールアドレスを正しく入力してください";
}elseif($_POST["email5"] && !filter_var($_POST["email5"], FILTER_VALIDATE_EMAIL)){
  $errorMessages[] = "メールアドレスを正しく入力してください";
}

if(!is_null($errorMessages)){
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: ./adduser_error.php');
}else{
  $mailList[] = $_SESSION["addcard"]["email"];
  $mailList[] = $_POST["email2"];
  $mailList[] = $_POST["email3"];
  $mailList[] = $_POST["email4"];
  $mailList[] = $_POST["email5"];
  $mailList = array_unique($mailList);
  $_SESSION["addcard"]["emaiList"] = $mailList;
  header('Location: ./adduser5_email.php');
}
?>
