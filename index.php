<?php 
session_start();
$lid = $_SESSION['lid'];
$lpw = $_SESSION['lpw'];

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//2. データ検索SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid = :lid");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);

// $stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);

// $stmt->bindValue(':lpw',$lpw, PDO::PARAM_STR); //* Hash化する場合はコメントする
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得

$val = $stmt->fetch(); 

if($val['id'] != "") {
  //Login成功時
  $_SESSION['chk_ssid']  = session_id();//SESSION変数にidを保存
  $_SESSION['kanri_flg'] = $val['kanri_flg'];//SESSION変数に管理者権限のflagを保存
  $_SESSION['name']      = $val['name'];//SESSION変数にnameを保存
  $_SESSION['lid']      = $val['lid'];//SESSION変数にnameを保存
  $_SESSION['lpw']      = $val['lpw'];//SESSION変数にnameを保存
}else{
  redirect("logout.php");
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    <?php  if($_SESSION['kanri_flg']): ?>
        <div class="navbar-header"><a class="navbar-brand" href="index_user.php">ユーザーデータ登録</a></div>
        <div class="navbar-header"><a class="navbar-brand" href="select_user.php">ユーザーデータ一覧</a></div> 
      <?php else :?>
  
      <?php endif; ?>
      <div class="navbar-header"><a class="navbar-brand" href="./ajax/ajax.html">Ajax</a></div>
      <div class="navbar-header"><a class="navbar-brand" href="./ajax_input">Ajax_input</a></div>
      <div class="navbar-header"><a class="navbar-brand" href="fileupload.html">写真アップロード</a></div>
      <div class="navbar-header"><a class="navbar-brand" href="./fileupload_sample">fileupload_sample</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>広告案件申込フォーム</legend>
     <label>ユーザーID<input type="text" name="instaid"></label><br>
     <label>ユーザーネーム<input type="text" name="username"></label><br>
     <label>Email：<input type="text" name="email"></label><br>
     <label>申し込みプラン<select name="entry">
      <option value="函館周遊プラン">函館周遊プラン</option>
      <option value="小樽食旅プラン">小樽食旅プラン</option>
      <option value="那須塩原温泉プラン">那須塩原温泉プラン</option>
    </select></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
