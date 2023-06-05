
<?php
include_once("auth.inc");
auth();
?>

<!DOCTYPE html>

<html lang="ja">

<head>
<link rel="stylesheet" type="text/css" href="final.css">
<title>
ゲーム
</title>
<meta charset="utf-8">
</head>

<body>
<div class="start">
<h1>ゲーム</h1>

<?php
print $_SERVER['PHP_AUTH_USER'];
print "さんがプレイ中<br>";
?>
    
<form action="yotto.php" method="post">
<ol>
<li><input type="radio" name="data10" value="0" checked>ニューゲーム</li>
<li><input type="radio" name="data10" value="1" >途中から</li>
</ol>
<input type="submit">

</form>

<hr>
<a href="index.php">戻る</a>

</div>    
</body>

</html>
