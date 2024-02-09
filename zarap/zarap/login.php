<?php
session_start();

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "zarap";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $login = $conn->real_escape_string($_POST['login']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM Administrators WHERE login = '$login' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Неправильный логин или пароль!';
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        Логин: <input type="text" name="login"><br>
        Пароль: <input type="password" name="password"><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
