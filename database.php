<?php
 // データベースへの接続
@$con = pg_connect(未記載);
// 先頭の@はエラーメッセージの出力を抑制するため。
if ($con == false){ // データベースに接続できなかった場合は、
  print("DATABASE CONNECTION ERROR\n"); // エラーメッセージを出力して、
  exit; // 強制終了する。
}


$sql1 = "delete from yotto";
pg_query($sql1);
$sql1 = "insert into yotto values('ace',0,0,0,0,1)";
pg_query($sql1);
$sql1 = "insert into yotto values('deuce',0,0,0,0,2)";
pg_query($sql1);
$sql1 = "insert into yotto values('tray',0,0,0,0,3)";
pg_query($sql1);
$sql1 = "insert into yotto values('four',0,0,0,0,4)";
pg_query($sql1);
$sql1 = "insert into yotto values('five',0,0,0,0,5)";
pg_query($sql1);
$sql1 = "insert into yotto values('six',0,0,0,0,6)";
pg_query($sql1);
$sql1 = "insert into yotto values('choice',0,0,0,0,7)";
pg_query($sql1);
$sql1 = "insert into yotto values('yotto',0,0,0,0,8)";
pg_query($sql1);
$sql1 = "insert into yotto values('合計',0,0,0,0,9)";
pg_query($sql1);

pg_close($con); // データベースとの接続を閉じる。
?>
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