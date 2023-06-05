<?php
 // データベースへの接続
@$con = pg_connect(未記載);
// 先頭の@はエラーメッセージの出力を抑制するため。
if ($con == false){ // データベースに接続できなかった場合は、
  print("DATABASE CONNECTION ERROR\n"); // エラーメッセージを出力して、
  exit; // 強制終了する。
}


$sql1 = "delete from player";
pg_query($sql1);
$sql1 = "insert into player values(0,0)";
pg_query($sql1);
$sql1 = "insert into player values(0,0)";
pg_query($sql1);

pg_close($con); // データベースとの接続を閉じる。
?>