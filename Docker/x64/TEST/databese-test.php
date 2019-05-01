<?php
$DB_HOST="db";
$DB_NAME="EEmgmt";
$DB_USER="root";
$DB_PASS="passwd";

// データベースへ接続//

   $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
   $sql = 'SELECT *  FROM user';
   $result = $pdo->query($sql);


  foreach ($result as $data) {
  echo $data['name'];
  echo '<br>' ;
  echo $data['password'];
  echo '<br>';
  }

?>
