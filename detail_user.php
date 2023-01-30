<?php
//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');
$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];


//3．データ取得SQLを作成（SELECT文）
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id =:id");
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
  <title>ユーザーデータ更新</title>
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
<form method="POST" action="update_user.php">
  <div class="jumbotron">
   <fieldset>
    <legend>データ更新</legend>
     <label>名前：<input type="text" name="name" value="<?= $result['name']?>"></label><br>
     <label>ログインID：<input type="text" name="lid" value="<?= $result['lid']?>"></label><br>
     <label>パスワード：<input type="text" name="lpw" value="<?= $result['lpw']?>"></label><br>
     <label>役職<select name="kanri_flg">
      <option value="0">管理者</option>
      <option value="1">スーパー管理者</option>
     </select></label><br>
     <label>ステータス<select name="life_flg">
      <option value="0">退社</option>
      <option value="1">入社</option>
     </select></label><br>
     <input type="hidden" name="id" value="<?= $result['id'] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>