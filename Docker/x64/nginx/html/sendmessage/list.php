<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}
$_SESSION["errorMessages"]= array();
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("sendnotice");
//権限確認
permission_redirect("sendnotice");

try {
    if($_GET["seach"]){
     $seach = $_GET["seach"];
     $countsql= "SELECT COUNT(idm) FROM service_user WHERE name LIKE '%".$seach."%'";
   }else{
     $countsql= "SELECT COUNT(idm) FROM service_user";
   }
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4',$DB_USER, $DB_PASS);
    $sql  = $pdo->prepare($countsql);
    $sql->execute();
    $counts = $sql->fetchColumn();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}

$maxPageCounts = $counts / 100;
$totalPageCounts = floor($maxPageCounts);  //小数点切り捨て
if (isset($_GET["pages"])){
  $pages = $_GET["pages"];
  $currentPages = $_GET["pages"];
  if($pages > $totalPageCounts){  //指定ページ数が実際のページより多い場合
    header('Location: ./list.php');
  }
  $pages *= 100;
  $pages -= 1;
}else{
  $pages = 0;
  $currentPages = 1;
}

try {
    if($seach){
      $userlistsql = "SELECT * FROM service_user WHERE name LIKE '%".$seach."%' ORDER BY idm LIMIT ".$pages." ,100";
    }else{
      $userlistsql = "SELECT * FROM service_user ORDER BY idm LIMIT ".$pages." ,100";
    }
    $sql  = $pdo->prepare($userlistsql);
    $sql->execute();
    $userlist=  $sql->fetchAll();
}catch (Exception $e){
  $errorMessages[] = "データベースエラーです";
  $_SESSION["errorMessages"]=$errorMessages;
  header('Location: /operate_error.php');
}


function pages($currentPages,$totalPageCounts){
  echo "ページ移動: ";
  if ($currentPages<=5){   //ページ数が5以下の場合の処理
    for($i=1; $i<=5; $i++){
      if($currentPages==$i){
        break;
      }
        echo '<a href="./list.php?pages='.$i.'">'.$i.'</a>';
        echo ' ';
  }
}else{  //通常処理
  echo '<a href="./list.php">1</a>';
  echo '...';
  for($i=1,$page=$currentPages-5; $i<=5; $i++,$page++){
      echo '<a href="./list.php?pages='.$page.'">'.$page.'</a>';
      echo ' ';
    }
  }
  echo $currentPages.' '; //現在ページ数

  $limitPage = $totalPageCounts-$currentPages;
  if($limitPage<=5){ //残りページ数が5以下の場合
    for($i=1,$page=$currentPages+1; $i<=$limitPage; $i++,$page++){
      echo '<a href="./list.php?pages='.$page.'">'.$page.'</a>';
      echo ' ';
    }
  }else{ //通常処理
  for($i=1,$page=$currentPages+1; $i<=5; $i++,$page++){
    echo '<a href="./list.php?pages='.$page.'">'.$page.'</a>';
    echo ' ';
  }
  echo '...';
  echo '<a href="./list.php?pages='.$totalPageCounts.'">'.$totalPageCounts.'</a>';
}
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>入退室管理システム</title>
    <link rel="stylesheet" href="/material/material.min.css">
    <script src="/material/material.min.js"></script>
    <link rel="stylesheet" href="/material/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="/custom.css">
  </head>
  <body>
    <!-- The drawer is always open in large screens. The header is always shown,
      even in small screens. -->
      <?php
      $menuName = "メッセージ送信";
      menuload($menuName);
      ?>
      <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->
          <div class="c-card-padding">
            <div class="c-large-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__supporting-text">
              ユーザー情報一覧
            </div>
            <div class="mdl-card__supporting-text">
              <form action="#" method="GET">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text"  name="seach" <?php echo "value=".$seach;?>>
                  <label class="mdl-textfield__label">検索</label>
                </div>

                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                    送信
                  </button>
                <button class="mdl-button mdl-js-button mdl-button--raised" onclick="location.href='./list.php'">
                  リセット
                </button>
              </form>
              <p>１ページにつき100件表示します</p>
              <p>ユーザー件数: <?php echo $counts;?></p>
              <p><?php pages($currentPages,$totalPageCounts); ?></p>
              <ul class='mdl-list'>
              <?php
              foreach($userlist as $username){
                echo '<li class="mdl-list__item mdl-list__item--three-line">';
                echo '<span class="mdl-list__item-primary-content">';
                echo '<i class="material-icons mdl-list__item-avatar">person</i>';
                echo '<span> <a href="./userpage.php?idm='.$username['idm'].'">'.$username['name'].'</a></span>';
                echo '<span class="mdl-list__item-text-body">'.'メールアドレス:'.$username["mainEmail"].'</span>';
                echo '</span>';
                echo '</li>';
              }
               ?>
              </ul>

              <p><?php pages($currentPages,$totalPageCounts); ?></p>
          </div>
          </div>

</div>
      </main>
    </div>

  </body>
</html>
