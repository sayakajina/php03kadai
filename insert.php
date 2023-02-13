<?php
session_start();

// 1. POSTデータ取得
$instaid = $_POST['instaid'];
$username = $_POST['username'];
$email = $_POST['email'];
$entry = $_POST['entry'];

// セッション変数からログインユーザーIDを取得

$user_id = $_SESSION['user_id'];

// 2. DB接続します
require_once('funcs.php');
$pdo = db_conn();


// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO gs_an_table( id,user_id,instaid,username,email,entry,indate )
  VALUES( NULL,:user_id, :instaid, :username, :email, :entry, sysdate() )"
);

// 4. バインド変数を用意
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':instaid', $instaid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':username', $username, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':entry', $entry, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  redirect('index.php');
}
?>
