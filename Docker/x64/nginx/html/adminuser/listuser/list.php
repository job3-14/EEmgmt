<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/db_setting.php');
include($_SERVER['DOCUMENT_ROOT'] . '/menu_load.php');
include($_SERVER['DOCUMENT_ROOT'] . '/permission.php');
//権限確認
permission_redirect("edituser");

try {
    if ($_GET["seach"]) {
        $seach = $_GET["seach"];
        $countsql= "SELECT COUNT(username) FROM login WHERE username LIKE '%".$seach."%'";
    } else {
        $countsql= "SELECT COUNT(username) FROM login";
    }
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4', $DB_USER, $DB_PASS);
    $sql  = $pdo->prepare($countsql);
    $sql->execute();
    $counts = $sql->fetchColumn();
} catch (Exception $e) {
    $errorMessages[] = "データベースエラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
    exit;
}

$maxPageCounts = $counts / 100;
$totalPageCounts = floor($maxPageCounts);  //小数点切り捨て
if (isset($_GET["pages"])) {
    $pages = $_GET["pages"];
    $currentPages = $_GET["pages"];
    if ($pages > $totalPageCounts) {  //指定ページ数が実際のページより多い場合
        header('Location: ./list.php');
        exit;
    }
    $pages *= 100;
    $pages -= 1;
} else {
    $pages = 0;
    $currentPages = 1;
}

try {
    if ($seach) {
        $userlistsql = "SELECT * FROM login WHERE username LIKE '%".$seach."%' ORDER BY addcard DESC LIMIT ".$pages." ,100";
    } else {
        $userlistsql = "SELECT * FROM login ORDER BY addcard DESC LIMIT ".$pages." ,100";
    }
    $pdo = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8mb4', $DB_USER, $DB_PASS);
    $sql  = $pdo->prepare($userlistsql);
    $sql->execute();
    $userlist=  $sql->fetchAll();
} catch (Exception $e) {
    $errorMessages[] = "データベースエラーです";
    $_SESSION["errorMessages"]=$errorMessages;
    header('Location: /operate_error.php');
    exit;
}

function permission($username)
{
    $permissionlist = "許可された権限:";
    if ($username['addcard']==1) {
        $permissionlist .= " カード登録 /";
        $count = 1;
    }
    if ($username['editcard']==1) {
        $permissionlist .= " カード編集・削除 /";
        $count = 1;
    }
    if ($username['sendnotice']==1) {
        $permissionlist .= " 入退室通知手動送信 /";
        $count = 1;
    }
    if ($username['viewexit']==1) {
        $permissionlist .= " 入退室履歴の閲覧 /";
        $count = 1;
    }
    if ($username['viewloginlog']==1) {
        $permissionlist .= " 管理者ログイン試行ログ閲覧 /";
        $count = 1;
    }
    if ($username['deletelog']==1) {
        $permissionlist .= " 入退室履歴の削除 /";
        $count = 1;
    }
    if ($username['initialize']==1) {
        $permissionlist .= " 初期化操作 /";
        $count = 1;
    }
    if ($username['setmail']==1) {
        $permissionlist .= " メールサーバー設定操作 /";
        $count = 1;
    }
    if ($username['shutdown']==1) {
        $permissionlist .= " システム操作 /";
        $count = 1;
    }
    if ($username['edituser']==1) {
        $permissionlist .= " 管理ユーザーの追加・編集・削除 /";
        $count = 1;
    }
    if ($count==1) {
        $permissionlist = substr($permissionlist, 0, -1);
    //0から-1を切り出し
    } else {
        $permissionlist = "許可された権限: なし";
    }
    return $permissionlist;
}

function pages($currentPages, $totalPageCounts)
{
    echo "ページ移動: ";
    if ($currentPages<=5) {   //ページ数が5以下の場合の処理
        for ($i=1; $i<=5; $i++) {
            if ($currentPages==$i) {
                break;
            }
            echo '<a href="./list.php?pages='.$i.'">'.$i.'</a>';
            echo ' ';
        }
    } else {  //通常処理
        echo '<a href="./list.php">1</a>';
        echo '...';
        for ($i=1,$page=$currentPages-5; $i<=5; $i++,$page++) {
            echo '<a href="./list.php?pages='.$page.'">'.$page.'</a>';
            echo ' ';
        }
    }
    echo $currentPages.' '; //現在ページ数

    $limitPage = $totalPageCounts-$currentPages;
    if ($limitPage<=5) { //残りページ数が5以下の場合
        for ($i=1,$page=$currentPages+1; $i<=$limitPage; $i++,$page++) {
            echo '<a href="./list.php?pages='.$page.'">'.$page.'</a>';
            echo ' ';
        }
    } else { //通常処理
        for ($i=1,$page=$currentPages+1; $i<=5; $i++,$page++) {
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
      $menuName = "管理者管理ページ";
      menuload($menuName);
      ?>
  <main class="mdl-layout__content">
    <div class="page-content">
      <!-- Your content goes here -->
      <div class="c-card-padding">
        <div class="c-large-card mdl-card mdl-shadow--4dp">
          <div class="mdl-card__supporting-text">
            ユーザー情報一覧
          </div>
          <div class="mdl-card__supporting-text">
            <form action="#" method="GET">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" name="seach" <?php echo "value=".$seach;?>>
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
            <?php
              if ($seach) {
                  echo "<p>'".$seach."'の検索結果</p>";
              }
               ?>
            <p>ヒット件数: <?php echo $counts;?></p>
            <p><?php pages($currentPages, $totalPageCounts); ?></p>
            <ul class='mdl-list'>
              <?php
              foreach ($userlist as $username) {
                  echo '<li class="mdl-list__item mdl-list__item--three-line">';
                  echo '<span class="mdl-list__item-primary-content">';
                  echo '<i class="material-icons mdl-list__item-avatar">person</i>';
                  echo '<span> <a href="./userpage.php?username='.$username['username'].'">'.$username['username'].'</a></span>';
                  echo '<span class="mdl-list__item-text-body">'.permission($username).'</span>';
                  echo '</span>';
                  echo '</li>';
              }
               ?>
            </ul>
            <p><?php pages($currentPages, $totalPageCounts); ?></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
