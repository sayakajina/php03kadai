<?php
//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_an_table");

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
    $url = 'https://www.instagram.com/' .$result['userid'];
    $view .= "<p>";
    $view .='<a href="detail_guest.php?id='.$result['id'].'">';
    $view .= $result['indate'].' | ';
    $view .='</a>';
    $view .='<a href="'.$url.'">';
    $view .= $result['userid'].' | ';
    $view .='</a>';
    $view .='<a href="detail_guest.php?id='.$result['id'].'">';
    $view .=$result['username'].' | '.$result['email'].' | '.$result['entry'];
    $view .='</a>';
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
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="index_guest.php">申込</a></div>
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
