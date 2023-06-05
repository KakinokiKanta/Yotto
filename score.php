<?php
include_once("auth.inc");
auth();
?>

<!DOCTYPE html>

<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="final.css">
<title>スコア</title>
<meta charset="utf-8">
</head>

<body>

<h1><span>スコア</span></h1>

<div class="special">
<?php
$user = $_SERVER['PHP_AUTH_USER'];
    
// データベースへの接続
@$con = pg_connect(未記載);
if($con == false){
  print("DATABASE CONNECTION ERROR1\n");
  exit;
}

$str="select * from {$user}player";
@$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
    print"DATA ACQUISITION ERROR2\n";
    exit;
}
for($i=0; $i<2; $i++){
    $player[]=pg_fetch_result($result,$i);
}

$str="select * from {$user}score";
@$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA ACQUISITION ERROR3\n";
  exit;
}

for($i=0; $i<5; $i++){
    $dice[]=pg_fetch_result($result,$i);
}

$str = "select * from {$user}yotto order by id"; // SQLのコマンド文を文字列に格納する。

@$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA ACQUISITION ERROR2\n";
  exit;
}

$n = 3; // 列数は3(hand,score1,score2)

$m = pg_num_rows($result);

for($i=0; $i<$m; $i++){
    $a=array();
    for($j=0; $j<$n; $j++){
        $a[]=pg_fetch_result($result,$i,$j);
    }
    $data[]=$a;
}

if(isset($_POST['hand'])){
    $k=0;
    $score=0;
    if($_POST['hand']==="ace"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==1){
                $k++;
            }
        }
        $score=$k;
    }else if($_POST['hand']==="deuce"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==2){
                $k++;
            }
        }
        $score=$k*2;
    }else if($_POST['hand']==="tray"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==3){
                $k++;
            }
        }
        $score=$k*3;
    }else if($_POST['hand']==="four"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==4){
                $k++;
            }
        }
        $score=$k*4;
    }else if($_POST['hand']==="five"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==5){
                $k++;
            }
        }
        $score=$k*5;
    }else if($_POST['hand']==="six"){
        for($i=0; $i<5; $i++){
            if($dice[$i]==6){
                $k++;
            }
        }
        $score=$k*6;
    }else if($_POST['hand']==="choice"){
        $score=0;
        for($i=0; $i<5; $i++){
            $score=$score+$dice[$i];
        }
    }else if($_POST['hand']==="S_straight"){
        $nn=count($dice);
        for($i=0; $i<$nn-1; $i++){
            $min=$i;
            for ($j=$i+1; $j<$nn; $j++) {
                if ($dice[$j]<$dice[$min]) {
                    $min=$j;
                }
            }	
            $tmp=$dice[$i];
            $dice[$i]=$dice[$min];
            $dice[$min]=$tmp;
        }
        for($i=0; $i<4; $i++){
            if($k==3){
                break;
            }else if($dice[$i]==$dice[$i+1]-1){
                $k++;
            }else if($dice[$i]==$dice[$i+1]){
            }else{
                $k=0;
            }
        }
        if($k==3){
            $score=15;
        }
    }else if($_POST['hand']==="B_straight"){
        $nn=count($dice);
        for($i=0; $i<$nn-1; $i++){
            $min=$i;
            for ($j=$i+1; $j<$nn; $j++) {
                if ($dice[$j]<$dice[$min]) {
                    $min=$j;
                }
            }	
            $tmp=$dice[$i];
            $dice[$i]=$dice[$min];
            $dice[$min]=$tmp;
        }
        for($i=0; $i<4; $i++){
            if($dice[$i]==$dice[$i+1]-1){
                $k++;
            }else{
                $k=0;
            }
        }
        if($k==4){
            $score=30;
        }
    }else if($_POST['hand']==="four_dice"){
        $nn=count($dice);
        for($i=0; $i<$nn-1; $i++){
            $min=$i;
            for ($j=$i+1; $j<$nn; $j++) {
                if ($dice[$j]<$dice[$min]) {
                    $min=$j;
                }
            }	
            $tmp=$dice[$i];
            $dice[$i]=$dice[$min];
            $dice[$min]=$tmp;
        }
        $score=0;
        for($i=0; $i<4; $i++){
            if($dice[$i]==$dice[$i+1]){
                $k++;
                $score=$score+$dice[$i];
            }else if($k==3){
                break;
            }else{
                $k=0;
            }
        }
        if($k<3){
            $score=0;
        }
    }else if($_POST['hand']==="full_house"){
        $nn=count($dice);
        for($i=0; $i<$nn-1; $i++){
            $min=$i;
            for ($j=$i+1; $j<$nn; $j++) {
                if ($dice[$j]<$dice[$min]) {
                    $min=$j;
                }
            }	
            $tmp=$dice[$i];
            $dice[$i]=$dice[$min];
            $dice[$min]=$tmp;
        }
        for($i=0; $i<4; $i++){
            if($dice[$i]==$dice[$i+1]){
                $k++;
            }else{
                $l=$k;
                $k=0;
            }
        }
        if(($k==1 && $l==2) || ($k==2 && $l==1)){
            $score=0;
            for($i=0; $i<5; $i++){
                $score=$score+$dice[$i];
            }
        }
    }else{
        for($i=0; $i<4; $i++){
            if($dice[$i]==$dice[$i+1]){
                $k++;
            }
        }
        if($k==4){
            $score=50;
        }
    }
    
    if($player[0]==12 &&$player[1]==11){
        print "<form action=\"judge.php\" method=\"post\">";

        print "<br>";
        print "勝敗は決した！！<br>";
        print "<br>勝者は...<br>";
        print "<br>";
        print "<input type=\"submit\" value=\"結果表示\">\n";
        print "</div>";

        print "</form>\n";
        
        print "<hr>\n";
        print "<a href=\"index.php\">戻る</a>\n";
        print "</body>\n";
        print "</html>\n";
        exit;
    }else if($player[0]==$player[1]){
        print "プレイヤー１→プレイヤー２<br>";
        print "<br>";
        $sql1="update {$user}yotto set score1={$score} where hand='{$_POST['hand']}'";
        pg_query($sql1);
        for($i=0; $i<$m; $i++){
            if($data[$i][0]==='合計'){
                $score=$score+$data[$i][1];
            }
        }
        $sql1="update {$user}yotto set score1={$score} where hand='合計'";
        pg_query($sql1);
        $sql1="update {$user}yotto set j1=1 where hand='{$_POST['hand']}'";
        pg_query($sql1);
        $sql1="update {$user}player set p1={$player[0]}+1";
        pg_query($sql1);
    }else{
        print "プレイヤー２→プレイヤー１<br>";
        print "<br>";
        $sql1="update {$user}yotto set score2={$score} where hand='{$_POST['hand']}'";
        pg_query($sql1);
        for($i=0; $i<$m; $i++){
            if($data[$i][0]==='合計'){
                $score=$score+$data[$i][2];
            }
        }
        $sql1="update {$user}yotto set score2={$score} where hand='合計'";
        pg_query($sql1);
        $sql1="update {$user}yotto set j2=1 where hand='{$_POST['hand']}'";
        pg_query($sql1);
        $sql1="update {$user}player set p2={$player[1]}+1";
        pg_query($sql1);
    }
}
    
$str = "select * from {$user}yotto order by id"; // SQLのコマンド文を文字列に格納する。

@$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
if($result == false){
  print"DATA ACQUISITION ERROR2\n";
  exit;
}

for($i=0; $i<$m; $i++){
    $b=array();
    for($j=0; $j<$n; $j++){
        $b[]=pg_fetch_result($result,$i,$j);
    }
    $data2[]=$b;
}

pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
pg_close($con); // データベースとの接続を閉じる。

print "<table>\n";
print "<tr><td>役</td><td>1P得点</td><td>2P得点</td><tr>";
for($i=0; $i<$m; $i++){
    print "<tr>";
    for($j=0; $j<$n; $j++){
        print "<td>".$data2[$i][$j]."</td>";
    }
    print "</tr>\n";
}
print "</table>\n";
?>
<form action="yotto.php" method="post">

<input type="submit" value="プレイヤー交代">
<div>

</form>

<hr>
<a href="index.php">戻る</a>
</body>
</html>

