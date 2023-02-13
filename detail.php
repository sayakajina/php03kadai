<?php
// 
session_start();



//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');
$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];


//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id =:id");
$stmt ->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$view = '';
if ($status == false){
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{
    $result = $stmt->fetch();//ここを追記！！
    
};

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

<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index.php">申込</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    <?php  if($_SESSION['kanri_flg']): ?>
        <div class="navbar-header"><a class="navbar-brand" href="index_user.php">ユーザーデータ登録</a></div>
        <div class="navbar-header"><a class="navbar-brand" href="select_user.php">ユーザーデータ一覧</a></div> 
      <?php else :?>
  
      <?php endif; ?>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>ユーザーID：<input type="text" name="instaid" value="<?= $result['instaid']?>"></label><br>
     <label>ユーザネーム：<input type="text" name="username" value="<?= $result['username']?>"></label><br>
     <label>Email：<input type="text" name="email" value="<?= $result['email']?>"></label><br>
     <label>申し込みプラン<select name="entry">
      <option value="函館周遊プラン">函館周遊プラン</option>
      <option value="小樽食旅プラン">小樽食旅プラン</option>
      <option value="那須塩原温泉プラン">那須塩原温泉プラン</option>
    </select></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>