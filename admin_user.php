<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: login.php');
//     exit();
// }

$servername = "sakura.ne.jp";
$username_db = "gs1";  // ユーザー名
$password_db = "--";  // パスワード
$dbname = "gs1_kadai_php01";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_selected'])) {
        if (!empty($_POST['delete_ids'])) {
            $delete_ids = implode(',', array_map('intval', $_POST['delete_ids']));
            $sql_delete = "DELETE FROM users WHERE id IN ($delete_ids)";
            if ($conn->query($sql_delete) === TRUE) {
                echo "Records deleted successfully";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error deleting records: " . $conn->error;
            }
        } else {
            echo "No records selected for deletion.";
        }
    }
    if (isset($_POST['delete'])) {
        $id_to_delete = intval($_POST['delete']);
        $sql_delete = "DELETE FROM users WHERE id = $id_to_delete";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Record deleted successfully";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
    if (isset($_POST['edit'])) {
        $id_to_edit = intval($_POST['id']);
        $username = $_POST['username'];
        $sex = $_POST['sex'];
        $age = intval($_POST['age']);
        $kanri_flg = intval($_POST['kanri_flg']);
        $sql_update = "UPDATE users SET username = '$username', sex = '$sex', age = $age, kanri_flg = $kanri_flg WHERE id = $id_to_edit";
        if ($conn->query($sql_update) === TRUE) {
            echo "Record updated successfully";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$search_hashed_id = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search_hashed_id'])) {
    $search_hashed_id = trim($_GET['search_hashed_id']);
}

$sql = "SELECT id, username, hashed_id, sex, age, timestamp, kanri_flg FROM users";
if (!empty($search_hashed_id)) {
    $sql .= " WHERE hashed_id LIKE '%" . $conn->real_escape_string($search_hashed_id) . "%'";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - User List</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles1.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>User List</h1>
            <div class="subtitle">
                <a href="admin_user_data.php" class="admin-data-link">Data List</a>
            </div>
            <div class="link-container">
                <a href="logout.php" class="logout-button">Log Out</a>
            </div>
        </div>
    </header>
    <div class="container">
        <form method="get" action="">
            <input type="text" name="search_hashed_id" placeholder="Search by Hashed ID" value="<?php echo htmlspecialchars($search_hashed_id); ?>">
            <button type="submit">Search</button>
        </form>
        <form method="post" action="">
            <div class="button-container">
                <button type="submit" name="delete_selected" class="delete-selected-button" onclick="return confirm('Are you sure you want to delete selected users?')">一括削除</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th class="hashed-id-column">Hashed ID</th>
                        <th class="sex-column">Sex</th>
                        <th class="age-column">Age</th>
                        <th class="timestamp-column">Timestamp</th>
                        <th class="kanri-flg-column">Kanri FLG</th>
                        <th class="action-column">Actions</th>
                        <th class="select-column">Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='username-column'>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td class='hashed-id-column'>" . htmlspecialchars($row['hashed_id']) . "</td>";
                            echo "<td class='sex-column'>" . htmlspecialchars($row['sex']) . "</td>";
                            echo "<td class='age-column'>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td class='timestamp-column'>" . htmlspecialchars($row['timestamp']) . "</td>";
                            echo "<td class='kanri-flg-column'>" . htmlspecialchars($row['kanri_flg']) . "</td>";
                            echo "<td class='button-group'>
                                    <button type='button' class='edit-button' data-id='" . $row['id'] . "' data-username='" . htmlspecialchars($row['username']) . "' data-hashed_id='" . htmlspecialchars($row['hashed_id']) . "' data-sex='" . htmlspecialchars($row['sex']) . "' data-age='" . htmlspecialchars($row['age']) . "' data-kanri_flg='" . htmlspecialchars($row['kanri_flg']) . "'>編集</button>
                                    <button type='submit' name='delete' value='" . $row['id'] . "' class='delete-button' onclick='return confirm(\"Are you sure?\")'>削除</button>
                                  </td>";
                            echo "<td class='select-column'><input type='checkbox' name='delete_ids[]' value='" . $row['id'] . "'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="">
                <input type="hidden" name="id" id="edit-id">
                <label for="edit-username">Username:</label>
                <input type="text" name="username" id="edit-username" required>
                <label for="edit-hashed_id">Hashed ID:</label>
                <input type="text" name="hashed_id" id="edit-hashed_id" readonly>
                <label for="edit-sex">Sex:</label>
                <input type="text" name="sex" id="edit-sex" required>
                <label for="edit-age">Age:</label>
                <input type="number" name="age" id="edit-age" required>
                <label for="edit-kanri_flg">Kanri FLG:</label>
                <input type="text" name="kanri_flg" id="edit-kanri_flg" required>
                <button type="submit" name="edit">更新</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById('edit-modal');
        var span = document.getElementsByClassName('close')[0];

        document.querySelectorAll('.edit-button').forEach(button => {
            button.onclick = function() {
                modal.style.display = 'block';
                document.getElementById('edit-id').value = this.getAttribute('data-id');
                document.getElementById('edit-username').value = this.getAttribute('data-username');
                document.getElementById('edit-hashed_id').value = this.getAttribute('data-hashed_id');
                document.getElementById('edit-sex').value = this.getAttribute('data-sex');
                document.getElementById('edit-age').value = this.getAttribute('data-age');
                document.getElementById('edit-kanri_flg').value = this.getAttribute('data-kanri_flg');
            };
        });

        span.onclick = function() {
            modal.style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>
</html>

