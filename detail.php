<?php
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
    <div class="navbar-header"><a class="navbar-brand" href="index.php">申込</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index_user.php">ユーザーデータ登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select_user.php">ユーザーデータ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>ユーザーID：<input type="text" name="userid" value="<?= $result['userid']?>"></label><br>
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