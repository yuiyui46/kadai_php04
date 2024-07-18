<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$servername = "sakura.ne.jp";
$username_db = "gs1";  // ユーザー名
$password_db = "--";  // パスワード
$dbname = "gs1_kadai_php01";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$user_data_id = isset($_SESSION['user_data_id']) ? $_SESSION['user_data_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // ユーザーが更新を選択した場合の処理
        $requestType = $_POST['requestType'];
        $requestContent = $_POST['requestContent'];

        // データベースを更新
        $stmt = $conn->prepare("UPDATE user_data SET request_type = ?, request_content = ? WHERE id = ? AND username = ?");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        if ($stmt->bind_param("ssis", $requestType, $requestContent, $user_data_id, $username) === false) {
            die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if ($stmt->execute() === false) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        $stmt->close();
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['delete'])) {
        // ユーザーが削除を選択した場合の処理
        $stmt = $conn->prepare("DELETE FROM user_data WHERE id = ? AND username = ?");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        if ($stmt->bind_param("is", $user_data_id, $username) === false) {
            die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if ($stmt->execute() === false) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        $stmt->close();
        unset($_SESSION['user_data_id']);
        unset($_SESSION['requestType']);
        unset($_SESSION['requestContent']);
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    } else {
        // ユーザーが新規登録を選択した場合の処理
        $requestType = $_POST['requestType'];
        $requestContent = $_POST['requestContent'];

        // タイムスタンプを取得
        $timestamp = date('Y-m-d H:i:s');

        // ユーザーデータを保存
        $stmt = $conn->prepare("INSERT INTO user_data (username, request_type, request_content, timestamp) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        if ($stmt->bind_param("ssss", $username, $requestType, $requestContent, $timestamp) === false) {
            die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if ($stmt->execute() === false) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $_SESSION['user_data_id'] = $stmt->insert_id;
        $_SESSION['requestType'] = $requestType;
        $_SESSION['requestContent'] = $requestContent;

        $stmt->close();
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
}

// データベースからユーザーデータを取得
$requestType = "";
$requestContent = "";

if ($user_data_id) {
    $stmt = $conn->prepare("SELECT request_type, request_content FROM user_data WHERE id = ? AND username = ?");
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    if ($stmt->bind_param("is", $user_data_id, $username) === false) {
        die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    if ($stmt->execute() === false) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $requestType = $row['request_type'];
        $requestContent = $row['request_content'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Data</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ご依頼</h1>
            <p class="note">～個人の方のためのご依頼フォームです。法人の場合は、<a href="https://example.com">https://example.com</a>よりご依頼をお願い致します。～</p>
        </div>
    </header>
    <div class="container">
        <form method="post" action="">
            <div class="category-container">
                <div class="category">
                    <h2>からだの相談</h2>
                    <img src="img/physical.png" alt="からだの相談">
                    <div class="radio-buttons">
                        <label>
                            <input type="radio" name="requestType" value="新規：からだの相談" <?php echo ($requestType == "新規：からだの相談") ? 'checked' : ''; ?> required>
                            新規
                        </label>
                        <label>
                            <input type="radio" name="requestType" value="2回目以降：からだの相談" <?php echo ($requestType == "2回目以降：からだの相談") ? 'checked' : ''; ?> required>
                            2回目以降
                        </label>
                    </div>
                </div>
                <div class="category">
                    <h2>こころの相談</h2>
                    <img src="img/mental.png" alt="こころの相談">
                    <div class="radio-buttons">
                        <label>
                            <input type="radio" name="requestType" value="新規：こころの相談" <?php echo ($requestType == "新規：こころの相談") ? 'checked' : ''; ?> required>
                            新規
                        </label>
                        <label>
                            <input type="radio" name="requestType" value="2回目以降：こころの相談" <?php echo ($requestType == "2回目以降：こころの相談") ? 'checked' : ''; ?> required>
                            2回目以降
                        </label>
                    </div>
                </div>
                <div class="category">
                    <h2>コーチング</h2>
                    <img src="img/coaching.png" alt="コーチング">
                    <div class="radio-buttons">
                        <label>
                            <input type="radio" name="requestType" value="新規：コーチング" <?php echo ($requestType == "新規：コーチング") ? 'checked' : ''; ?> required>
                            新規
                        </label>
                        <label>
                            <input type="radio" name="requestType" value="2回目以降：コーチング" <?php echo ($requestType == "2回目以降：コーチング") ? 'checked' : ''; ?> required>
                            2回目以降
                        </label>
                    </div>
                </div>
            </div>
            <label for="requestContent" class="center-label bold-label">具体的なご相談内容:</label><br>
            <textarea name="requestContent" id="requestContent" maxlength="500" required><?php echo htmlspecialchars($requestContent); ?></textarea><br>

            <div class="button-container">
                <input type="submit" name="submit" value="新規登録">
                <input type="submit" name="update" value="更新">
                <input type="submit" name="delete" value="削除">
            </div>
        </form>
        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
    </div>
</body>
</html>
