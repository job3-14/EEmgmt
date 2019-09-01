<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}

if ($_SESSION["adduser2_status"] !== 2) {
    header('Location: ./adduser.php');
    exit;
}

include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("addcard");

try {
    if (!$_POST["user"]=="") {
        $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4', $DB_USER, $DB_PASS);
        $sql  = $pdo->prepare("SELECT EXISTS(SELECT username FROM service_user WHERE mainEmail = ?)");
        $sql->bindValue(1, $_POST["user"]);
        $sql->execute();
        $result=  $sql->fetchColumn();
    }
} catch (Exception $e) {
    $errorMessages[] = "データベースエラーです";
}

if ($result==1) {
    $errorMessages[] = "このメールアドレス(メイン)は既に利用されています。他のメールアドレスを入力してください";
}
if ($_POST["email2"] && !filter_var($_POST["email2"], FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "メールアドレスを正しく入力してください";
} elseif ($_POST["email3"] && !filter_var($_POST["email3"], FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "メールアドレスを正しく入力してください";
} elseif ($_POST["email4"] && !filter_var($_POST["email4"], FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "メールアドレスを正しく入力してください";
} elseif ($_POST["email5"] && !filter_var($_POST["email5"], FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "メールアドレスを正しく入力してください";
}

if (!is_null($errorMessages)) {
    $_SESSION["errorMessages"]=$errorMessages;
    $_SESSION["adduser2_status"] = 1;
    header('Location: /normal_error.php');
    exit;
} else {
    $mailList[] = $_SESSION["addcard"]["email"];
    if ($_POST["email2"]) {
        $mailList[] = $_POST["email2"];
    }
    if ($_POST["email3"]) {
        $mailList[] = $_POST["email3"];
    }
    if ($_POST["email4"]) {
        $mailList[] = $_POST["email4"];
    }
    if ($_POST["email5"]) {
        $mailList[] = $_POST["email5"];
    }
    $mailList = array_unique($mailList); //重複削除
    $_SESSION["addcard"]["emaiList"] = $mailList;
    $_SESSION["adduser2_status"] = 3;
    header('Location: ./adduser5_email.php');
    exit;
}
