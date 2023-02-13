<?php
session_start();
require_once('funcs.php');
loginCheck();

//insert.phpの処理を持ってくる
//1. POSTデータ取得
$name      = filter_input( INPUT_POST, "name" );
$lid       = filter_input( INPUT_POST, "lid" );
$lpw       = filter_input( INPUT_POST, "lpw" );
$kanri_flg = filter_input( INPUT_POST, "kanri_flg" );
$life_flg  = filter_input( INPUT_POST, "life_flg" );
$id        = filter_input( INPUT_POST, "id" );


//2. DB接続します
$pdo = db_conn();

//3.データ登録SQL作成
if($lpw==""){
  $sql = "UPDATE gs_user_table SET name=:name,lid=:lid,kanri_flg=:kanri_flg,life_flg=:life_flg WHERE id=:id";
}else{
  $sql = "UPDATE gs_user_table SET name=:name,lid=:lid,lpw=:lpw,kanri_flg=:kanri_flg,life_flg=:life_flg WHERE id=:id";
}
//4.SQL
$stmt = $pdo->prepare($sql);

  // 4. バインド変数を用意
  if($lpw!=""){
    $stmt->bindValue(':lpw', password_hash($lpw, PASSWORD_DEFAULT), PDO::PARAM_STR);
  } 
  $stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
  $stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT); 
  $stmt->bindValue(':life_flg', $life_flg, PDO::PARAM_INT); 
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMassage:".$error[2]);
  }else{
    //５．index.phpへリダイレクト
    redirect('select_user.php');
  }