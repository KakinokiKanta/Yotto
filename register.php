<!DOCTYPE html>

<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="finalex.css">
<title>
ユーザー登録
</title>
<meta charset="utf-8">
</head>

<body>
<h1>ユーザー登録</h1>

<?php

 // データベースへの接続
@$con = pg_connect(未記載);
if ($con == false){
  print("DATABASE CONNECTION ERROR1\n");
  exit;
}


$sql1 = "select uname from passdb where uname = '{$_POST['uname']}'"; // SQLのコマンド文を文字列に格納する。

print $sql1."<br>";

@$result = pg_query($sql1); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA ACQUISITION ERROR2\n";
  exit;
}

$row = pg_num_rows($result);

pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

if($row > 0){ // 入力されたユーザ名が、データベースの中に１つ以上ある時は「登録済み」

  pg_close($con); // データベースとの接続を閉じる。

  print "<p>\n";
  print "そのユーザ名は登録済みです。\n";
  print "</p>\n";

  print "<p>\n";
  print "<a href=\"index.php\">戻る</a>\n";
  print "</p>\n";

  print "</body>\n";

  print "</html>\n";

  exit;
}

// 以下は、プログラミングドリルの1-cを参照せよ

$sql1 = "insert into passdb values('".$_POST['uname']."','".$_POST['pass']."')"; // テーブルpassdbに、ユーザ名とパスワードを登録する。

@$result = pg_query($sql1); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA INSERTION ERROR3\n";
  exit;
}

$sql2 = "create table ".$_POST['uname']."yotto (hand text, score1 int, score2 int, j1 int, j2 int, id int)";
print $sql2."<br>";

@$result = pg_query($sql2); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"TABLE CREATION ERROR\n";
  exit;
}
$sql1 = "insert into ".$_POST['uname']."yotto values('ace',0,0,0,0,1)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('deuce',0,0,0,0,2)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('tray',0,0,0,0,3)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('four',0,0,0,0,4)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('five',0,0,0,0,5)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('six',0,0,0,0,6)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('choice',0,0,0,0,7)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('yotto',0,0,0,0,8)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."yotto values('合計',0,0,0,0,9)";
pg_query($sql1);

$sql2 = "create table ".$_POST['uname']."player (p1 int, p2 int)";
print $sql2."<br>";

@$result = pg_query($sql2); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"TABLE CREATION ERROR\n";
  exit;
}
$sql1 = "insert into ".$_POST['uname']."player values(0,0)";
pg_query($sql1);
$sql1 = "insert into ".$_POST['uname']."player values(0,0)";
pg_query($sql1);

$sql2 = "create table ".$_POST['uname']."score (d1 int, d2 int, d3 int, d4 int, d5 int)";
print $sql2."<br>";

@$result = pg_query($sql2); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"TABLE CREATION ERROR\n";
  exit;
}
$sql1 = "insert into ".$_POST['uname']."score values(0,0,0,0,0)";
pg_query($sql1);

pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
pg_close($con); // データベースとの接続を閉じる。
?>

<p>
ユーザを登録しました。
</p>

<p>
<a href="index.php">戻る</a>
</p>

</body>

</html>
