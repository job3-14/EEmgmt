<?php
$DB_HOST="db";
$DB_NAME="EEmgmt";
$DB_USER="root";
$DB_PASS="passwd";

// PHPのエラーを表示するように設定///////
error_reporting(E_ALL & ~E_NOTICE);  ////
/////////////////////////////////////////開発時以外は削除

// データベースへ接続//
$pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);

?>
