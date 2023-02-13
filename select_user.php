<?php
session_start();
//1.  DB接続します
require_once('funcs.php');
loginCheck();

$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= "<p>";
    $view .='<a href="detail_user.php?id='.$result['id'].'">';
    $view .= $result['name'].' | '.$result['lid'];
    $view .='</a>';
    $view .='<a href="delete_user.php?id='.$result['id'].'">';
    $view .= ' [削除]';
    $view .= '</a>';
    $view .= "</p>";
  };

};
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>申し込み一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <?php echo $_SESSION["name"]; ?>さん
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index.php">申込</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index_user.php">ユーザーデータ登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>
