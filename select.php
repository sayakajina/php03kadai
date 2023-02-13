<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_an_table INNER JOIN gs_user_table ON gs_an_table.user_id = gs_user_table.id");

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
    $url = 'https://www.instagram.com/' .$result['instaid'];
    $view .= "<p>";
    $view .='<a href="detail.php?id='.$result['id'].'">';
    $view .= $result['indate'].' | ';
    $view .='</a>';
    $view .='<a href="'.$url.'">';
    $view .= $result['instaid'].' | ';
    $view .='</a>';
    $view .='<a href="detail.php?id='.$result['id'].'">';
    $view .=$result['username'].' | '.$result['email'].' | '.$result['entry'].' | '.$result['name'];
    $view .='</a>';
    $view .='<a href="delete.php?id='.$result['id'].'">';
    $view .= ' [削除]';
    $view .= '</a>';
    $view .= "</p>";
  };

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
      <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
      <div class="navbar-header"><a class="navbar-brand" href="index.php">申込</a></div>
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
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>
