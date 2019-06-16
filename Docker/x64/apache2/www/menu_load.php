<?php
session_start();
if (!isset($_SESSION["user"])){
header('Location: /login.php');
}

function menuload(){
echo '<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">'
echo '<header class="mdl-layout__header">'
echo '<div class="mdl-layout__header-row">'
echo '<div class="head-title">'
echo '<span class="mdl-layout-title">管理トップ</span>'
echo '</div>'
echo '<div class="mdl-layout-spacer"></div>'
echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">'
echo '<div class="logout">'
echo '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href='/logout.php'">'
echo 'ログアウト'
echo '</button>'
echo '</div>'
echo '</div>'
echo '</div>'
echo '</header>'
echo '<div class="mdl-layout__drawer">'
echo '<span class="mdl-layout-title">入退室管理システム</span>'
echo '<nav class="mdl-navigation">'
echo '<a class="mdl-navigation__link" href="/index.php">管理トップ</a>'
echo '<a class="mdl-navigation__link" href="/adminuser/adminuser.php">管理ユーザー</a>'
echo '<a class="mdl-navigation__link" href="/service_user/service_user.php">利用ユーザー</a>'
echo '<a class="mdl-navigation__link" href="">システム操作</a>'
echo '</nav>'
echo '</div>'
}
?>
