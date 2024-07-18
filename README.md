# ①課題番号-プロダクト名　　
-ブックマークアプリ（Session・ログイン）　　

# ②課題内容（どんな作品か）　　
-個人クライアント相談依頼データの各種リスト管理

# ③DEMO　　
https://gs1.sakura.ne.jp/kadai_php01_fz/admin_user.php<br>
https://gs1.sakura.ne.jp/kadai_php01_fz/admin_user_data.php<br>

# ④作ったアプリケーション用のIDまたはPasswordがある場合　　
-ID: 今回なし　　
-PW: 今回なし　　

# ⑤こだわった点
<管理者画面><br>
-パスワードのハッシュ化<br>
-IDのハッシュ化（PWはハッシュ化しても一覧表示のリスク大とのことだったため、今後、複数スタッフでの個人情報管理を見据えて匿名化共有IDとしてハッシュID発行機能を付けた）<br>
-ハッシュIDでクライアント情報を検索<br>
-kanri_flg機能<br>
-User ListとData Listのそれぞれの管理画面と両画面へのリンク機能<br>
-両管理画面のリスト上での、編集、削除、選択したuserの一括削除機能<br>
<br>
<User画面>（前回URL）<br>
-ログイン認証<br>
-データ取得時に初回依頼者と2回目以降の依頼者の区別<br>
-依頼内容登録画面で、新規依頼、変更・更新、キャンセルをサーバー情報から区別、適切ではないボタンが押された時にはアラートを出し、適切なボタンを誘導する＆変更・キャンセル時は個別連絡へ誘導する機能<br>

# ⑥難しかった点・次回トライしたいこと(又は機能)　　
-管理画面作成中に、前回のUser画面のCSSがChromeとEdgeで微妙に異なり崩れていることに今更気づいた。管理画面に影響はない。User画面は何度か直そうとしたが上手くいかないので現在修復中で全体的に崩れています。こちらは別途この後修正します。入力・保存機能には問題なしです。<br>
-法人クライアントは法人用フォームから依頼できるようHPを分岐させたいが、法人用フォーム作成までには時間が足りず。これから実施したいです。<br>
-管理者画面に登録データをCSVでDLできるボタンを追加したいです。もし可能なら、クライアントが増えた場合は、クライアント傾向を週次、月次で自動でグラフ化して表示する画面も付けたいです<br>

# ⑦質問・疑問・感想、シェアしたいこと等なんでも  
-提出が遅れてしまい、申し訳ございません。
