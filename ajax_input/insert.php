<?php
session_start();

// 1. POSTデータ取得
$instaid = $_POST['instaid'];
$username = $_POST['username'];
$email = $_POST['email'];
$entry = $_POST['entry'];

// セッション変数からログインユーザーIDを取得

$user_id = $_SESSION['user_id'];


//2. DB接続します(エラー処理追加)
require_once("../funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
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

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  echo "false";
}else{
  echo "true";
}
?>
