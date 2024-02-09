<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "zarap";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $conn->real_escape_string($_POST['name']); // Имя
$phone = $conn->real_escape_string($_POST['phone']); // Номер телефона

// SQL запрос на вставку данных
$sql = "INSERT INTO Appointments (name, phone_number, appointment_date) VALUES ('$name', '$phone', CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
