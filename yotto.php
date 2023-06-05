<?php
include_once("auth.inc");
auth();
?>

<!DOCTYPE html>

<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="final.css">
<title>ヨット</title>
<meta charset="utf-8">
</head>

<body>

<h1><span>〜ヨット〜</span></h1>

<div class="special">
<?php
$user = $_SERVER['PHP_AUTH_USER'];
    if(isset($_POST['data10'])){
        if($_POST['data10']==0){
            // データベースへの接続
            @$con = pg_connect(未記載);// 先頭の@はエラーメッセージの出力を抑制するため。
            if ($con == false){ // データベースに接続できなかった場合は、
                print("DATABASE CONNECTION ERROR\n"); // エラーメッセージを出力して、
                exit; // 強制終了する。
            }
            
            $sql1 = "delete from {$user}yotto";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('ace',0,0,0,0,1)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('deuce',0,0,0,0,2)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('tray',0,0,0,0,3)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('four',0,0,0,0,4)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('five',0,0,0,0,5)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('six',0,0,0,0,6)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('choice',0,0,0,0,7)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('four_dice',0,0,0,0,8)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('full_house',0,0,0,0,9)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('S_straight',0,0,0,0,10)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('B_straight',0,0,0,0,11)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('yotto',0,0,0,0,12)";
            pg_query($sql1);
            $sql1 = "insert into {$user}yotto values('合計',0,0,0,0,13)";
            pg_query($sql1);
            
            $sql1 = "delete from {$user}player";
            pg_query($sql1);
            $sql1 = "insert into {$user}player values(0,0)";
            pg_query($sql1);
            $sql1 = "insert into {$user}player values(0,0)";
            pg_query($sql1);
            
            pg_close($con); // データベースとの接続を閉じる。
        }
    }
?>

<?php
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
if($player[0]==$player[1]){
    print "プレイヤー１の番です";
}else{
    print "プレイヤー２の番です";
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


if(isset($_POST['COUNT'])){
    $c=$_POST['COUNT'];
}else{
    $c=0;
}
?>

<?php
if($c==3){
    print "<form action=\"score.php\" method=\"post\">";
    $c++;
    print "<input type=\"hidden\" name=\"COUNT\" value=$c>";
    print "<div class=\"socre\">";
    print "<table>\n";
    print "<tr><td></td><td>役</td><td>1P得点</td><td>2P得点</td><tr>";
    $cc=0;
    for($i=0; $i<$m; $i++){
        print "<tr>";
        if($data[$i][0]=="合計"){
            print "<td></td>";
        }else{
            if($player[0]==$player[1]){
                if($data[$i][3]==0){
                    if($cc==0){
                        print "<td><input type=\"radio\" name=\"hand\" value=\"{$data[$i][0]}\" checked></td>";
                        $cc++;
                    }else{
                        print "<td><input type=\"radio\" name=\"hand\" value=\"{$data[$i][0]}\"></td>";
                    }
                }else{
                    print "<td></td>";
                }
            }else{
                if($data[$i][4]==0){
                    if($cc==0){
                        print "<td><input type=\"radio\" name=\"hand\" value=\"{$data[$i][0]}\" checked></td>";
                        $cc++;
                    }else{
                       print "<td><input type=\"radio\" name=\"hand\" value=\"{$data[$i][0]}\"></td>";
                    }
                }else{
                    print "<td></td>";
                }
            }        
        }
        for($j=0; $j<3; $j++){
            print "<td>".$data[$i][$j]."</td>";
        }
        print "</tr>\n";
    }
    print "</table>\n";
    print "</div>";

    print "<br>";

    print "<div class=\"dice\">";
    print "サイコロの目は以下の通りです<br>";
    print "<table>\n";
    print "<tr>";
    if(isset($_POST['dice'])){
        $n=count($_POST['dice']);
        $d=$_POST['dice'];
        for($i=$n; $i<5; $i++){
            $d[]=mt_rand(1,6);
        }
        for($i=0; $i<5; $i++){
            print "<td>";
            print "<center>".$d[$i]."</center>";
            print "</td>";
        }
    }else{
        for($i=0; $i<5; $i++){
            $d[]=mt_rand(1,6);
        }
        for($i=0; $i<5; $i++){
            print "<td>";
            print "<center>".$d[$i]."</center>";
            print "</td>";
        }
    }
    print "</tr>\n";
    print "<tr>\n";
    for($i=0; $i<5; $i++){
        print "<td><img src=\"saikoro{$d[$i]}\" width=\"50\" height=\"50\"></td>";
    }
    print "</tr>\n";
    print "</table>\n";

    $str="select * from {$user}score";

    @$result = pg_query($str); // SQLのコマンドでデータベースに問い合わせする。
    if($result == false){
        print"DATA ACQUISITION ERROR2\n";
        exit;
    }

    $sql1="update {$user}score set d1=$d[0],d2=$d[1],d3=$d[2],d4=$d[3],d5=$d[4]";
    pg_query($sql1);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    pg_close($con); // データベースとの接続を閉じる。

    print "<input type=\"submit\" div class=\"button\" value=\"確定\">\n";
    print "</div>";
    print "</div>";

    print "</form>\n";
    print "</div>";

    print "<hr>\n";
    print "<a href=\"index.php\">戻る</a>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
}

pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
pg_close($con); // データベースとの接続を閉じる。
?>

<form action="yotto.php" method="post">

<?php  
$c++;
print "<input type=\"hidden\" name=\"COUNT\" value=$c>";

print "<div class=\"score\">";
print "<table>\n";
print "<tr><td>役</td><td>1P得点</td><td>2P得点</td><tr>";
for($i=0; $i<$m; $i++){
    print "<tr>";
    for($j=0; $j<3; $j++){
        print "<td>".$data[$i][$j]."</td>";
    }
    print "</tr>\n";
}
print "</table>\n";
print "</div>";

if($c==1){
    $c++;
    print "<div class=\"dice\">";
    print "<input type=\"submit\" div class=\"button\" value=\"サイコロを振る\">\n";
    print "</div>";
    print "</form>\n";
    print "</div>\n";
    print "</div>\n";

    print "<hr>\n";
    print "<a href=\"index.php\">戻る</a>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
    
}

print "<br>";
print "<div class=\"dice\">";
print "保持するサイコロを選択してください<br>";
print "<table>\n";
print "<tr>";
if(isset($_POST['dice'])){
    $n=count($_POST['dice']);
    $d=$_POST['dice'];
    for($i=$n; $i<5; $i++){
        $d[]=mt_rand(1,6);
    }
    for($i=0; $i<$n; $i++){
        print "<td><input type=\"checkbox\" name=\"dice[]\" value=\"{$d[$i]}\"checked>{$d[$i]}</td>";
    }
    for($i; $i<5; $i++){
        print "<td><input type=\"checkbox\" name=\"dice[]\" value=\"{$d[$i]}\">{$d[$i]}</td>";
    }
}else{
    for($i=0; $i<5; $i++){
        $d[]=mt_rand(1,6);
    }
    for($i=0; $i<5; $i++){
        print "<td><input type=\"checkbox\" name=\"dice[]\" value=\"{$d[$i]}\">{$d[$i]}</td>";
    }
}
print "</tr>\n";
print "<tr>";
for($i=0; $i<5; $i++){
    print "<td><img src=\"saikoro{$d[$i]}\" width=\"50\" height=\"50\"></td>";
}
print "</tr>\n";
print "</table>\n";
?>

<input type="submit" div class="button" value="これに決めた！">
</div>
</div>

</form>

<hr>
<a href="index.php">戻る</a>
</body>
</html>

