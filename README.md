# Yotto
大学2年生の時に、PHPで作成したWebゲーム「ヨット」を置くためのリポジトリです。大学のDBを利用しているため、ゲームは非公開となっています。
## 「ヨット」の画面遷移図
![interface](https://github.com/KakinokiKanta/Yotto/assets/105735727/0c47d83d-8cb5-4d8b-b9c4-b95234ae9809)
## score.php の 処理
1. FORM から送られてきた値5つのサイコロの目、選択した役を取り出す。
2. データベースのyottoテーブルからデータ役、そのそれぞれでの現在の得点、役毎のidを取得する。
3. フォームから受け取った値5つのサイコロの目、選択した役に応じてデータベースを更新する。
4. 更新後のデータベースのyottoテーブルから、新しいデータを取得する。
5. 4で入手したデータから役、1Pの得点、2Pの得点を列とした表を表示する。
6. yotto.phpに移動する。
## judge.phpの処理
1. データベースのyottoテーブルからデータ役、そのそれぞれでの現在の得点を取得する。
2. 役の列の内、合計の行での1Pと2Pの得点を比べ、それに応じた表示をする。
3. 戻るボタンでindex.php に移動する。
