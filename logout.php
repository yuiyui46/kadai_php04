<?php
session_start();

// SESSION初期化
$_SESSION = array();

// Cookieに保存してたSessionIDの保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄
session_destroy();

header('Location: login.php'); // ログインページにリダイレクト
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ユーザーダッシュボード</title>
</head>
<body>
    <h1>ようこそ, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <!-- その他のダッシュボードコンテンツ -->

    <form action="logout.php" method="post">
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>
