<?php
include_once("auth.inc");
auth();
?>

<!DOCTYPE html>

<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="final.css">
<title>
勝敗
</title>
<meta charset="utf-8">
</head>

<body>

<h1><span>勝敗</span></h1>

<?php
$user = $_SERVER['PHP_AUTH_USER'];

// データベースへの接続
@$con = pg_connect(未記載);
if ($con == false){
  print("DATABASE CONNECTION ERROR\n");
  exit;
}

$str = "select * from {$user}yotto order by id"; // SQLのコマンド文を文字列に格納する。
@$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA ACQUISITION ERROR2\n";
  exit;
}

$n = 6; // 列数は6(hand,score1,score2,j1,j2,id)

$m = pg_num_rows($result);

for($i=0; $i<$m; $i++){
    $a=array();
    for($j=0; $j<$n; $j++){
        $a[]=pg_fetch_result($result,$i,$j);
    }
    $data[]=$a;
}

print "<br>";
if($data[$m-1][1]==$data[$m-1][2]){
    print "引き分け...<br>";
}else if($data[$m-1][1]>$data[$m-1][2]){
    print "プレイヤー１の勝利！！！！！！！<br>";
}else{
    print "プレイヤー２の勝利！！！！！！！<br>";
}
print "<br>";

pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
pg_close($con); // データベースとの接続を閉じる。

?>

<hr>
<a href="index.php">トップに戻る</a>

</body>
</html>
