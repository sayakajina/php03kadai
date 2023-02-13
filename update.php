<?php
//insert.phpの処理を持ってくる
//1. POSTデータ取得
$instaid = $_POST['instaid'];
$username = $_POST['username'];
$email = $_POST['email'];
$entry = $_POST['entry'];
$id = $_POST["id"];



//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ更新SQL作成（UPDATE テーブル名 SET 更新対象1=:更新データ ,更新対象2=:更新データ2,... WHERE id = 対象ID;）
$stmt = $pdo->prepare(
    "UPDATE gs_an_table SET instaid = :instaid, username = :username, email = :email, entry = :entry, indate = sysdate() WHERE id = :id;");
  
  // 4. バインド変数を用意
  $stmt->bindValue(':instaid', $instaid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':username', $username, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':entry', $entry, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
  
  // 5. 実行
  $status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMassage:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    redirect('index.php');
  }