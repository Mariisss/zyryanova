<?php
session_start();

// Простая проверка на "авторизацию"
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Параметры подключения к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "zarap";
$port = 3306;

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка добавления фотографии
if (isset($_FILES['photo'])) {
    $imagePath = 'uploads/' . basename($_FILES['photo']['name']);
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath)) {
        $conn->query("INSERT INTO Works (image_path) VALUES ('$imagePath')");
        // После добавления фотографии перенаправляем обратно на страницу "Фото работ"
        header('Location: admin.php');
        exit;
    }
}

// Обработка удаления фотографии
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $imagePath = '';
    
    // Получим путь к изображению из базы данных
    $result = $conn->query("SELECT image_path FROM Works WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image_path'];
    }
    
    // Удалим изображение с диска
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    
    // Удалим запись из базы данных
    $conn->query("DELETE FROM Works WHERE id = $id");
    
    // После удаления фотографии перенаправляем обратно на страницу "Фото работ"
    header('Location: admin.php');
    exit;
}

// Обработка добавления или обновления услуги
if (isset($_POST['service_action'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    
    // Загрузка изображения, если оно было выбрано
    $imagePath = '';
    if ($_FILES['image']['name']) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Удалить старое изображение, если оно было
            $oldImagePath = $_POST['old_image_path'];
            if (!empty($oldImagePath) && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        } else {
            // Ошибка при загрузке изображения
            // Обработайте эту ошибку по вашему усмотрению
        }
    } else {
        // Изображение не выбрано, сохраняем старый путь
        $imagePath = $_POST['image_path'];
    }
    
    if ($_POST['service_action'] == 'add') {
        $conn->query("INSERT INTO Services (name, type, image_path, price) VALUES ('$name', '$type', '$imagePath', '$price')");
    } elseif ($_POST['service_action'] == 'edit' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $conn->query("UPDATE Services SET name='$name', type='$type', image_path='$imagePath', price='$price' WHERE id=$id");
    }
    // После добавления или обновления услуги перенаправляем обратно на страницу "Услуги"
    header('Location: admin.php');
    exit;
}

// Обработка удаления услуги
if (isset($_POST['delete_service']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $imagePath = '';
    
    // Получим путь к изображению из базы данных
    $result = $conn->query("SELECT image_path FROM Services WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image_path'];
    }
    
    // Удалим изображение с диска
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    
    // Удалим запись из базы данных
    $conn->query("DELETE FROM Services WHERE id = $id");
    
    // После удаления услуги перенаправляем обратно на страницу "Услуги"
    header('Location: admin.php');
    exit;
}

// Обработка AJAX-запроса
if (isset($_POST['content'])) {
    $content = $_POST['content'];
    switch ($content) {
        case 'Входящие заявки':
            $result = $conn->query("SELECT * FROM Appointments");
            if ($result->num_rows > 0) {
                echo "<table><tr><th>ID</th><th>Имя</th><th>Номер Телефона</th><th>Дата Заявки</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["phone_number"] . "</td><td>" . $row["appointment_date"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Заявок нет";
            }
            break;
        case 'Фото работ':
            echo '<form action="admin.php" method="post" enctype="multipart/form-data">
                      <input type="file" name="photo" required>
                      <button type="submit">Загрузить фото</button>
                  </form>';
            $result = $conn->query("SELECT * FROM Works");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div><img src="' . $row["image_path"] . '" style="width:100px;height:100px;"><br>
                              <button onclick="deletePhoto(' . $row["id"] . ')">Удалить</button>
                          </div>';
                }
            } else {
                echo "Фотографий нет";
            }
            break;
        case 'Услуги':
            echo '<form id="serviceForm" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="service_action" id="serviceAction" value="add">
                      <input type="hidden" name="id" id="serviceId">
                      Название: <input type="text" name="name" id="serviceName" required><br>
                      Тип: <select name="type" id="serviceType">
                        <option value="Ручной">Ручной</option>
                        <option value="Аппаратный">Аппаратный</option>
                        <option value="Ручной/Аппаратный">Ручной/Аппаратный</option>
                        <option value="Комбинированный">Комбинированный</option>
                     </select><br>
                      Загрузить изображение: <input type="file" name="image"><br>
                      Путь к изображению: <input type="text" name="image_path" id="serviceImagePath" required><br>
                      Цена: <input type="number" name="price" id="servicePrice" required><br>
                      <button type="submit">Сохранить</button>
                  </form>';

            $result = $conn->query("SELECT * FROM Services");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="service-item" id="service-' . $row["id"] . '"
                              data-name="' . $row["name"] . '"
                              data-type="' . $row["type"] . '"
                              data-image-path="' . $row["image_path"] . '"
                              data-price="' . $row["price"] . '">
                              ' . $row["name"] . ' - ' . $row["type"] . ' - ' . $row["price"] . ' руб.
                              <button onclick="editService(' . $row["id"] . ')">Редактировать</button>
                              <button onclick="deleteService(' . $row["id"] . ')">Удалить</button>
                          </div>';
                }
            } else {
                echo "Услуг нет";
            }
            break;
    }
    exit;
}

$menuItems = ['Входящие заявки', 'Услуги', 'Фото работ'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/admin.css">
    
</head>
<body>
    <ul class="menu">
        <?php foreach ($menuItems as $item): ?>
            <li onclick="showContent('<?php echo $item; ?>')"><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="content" id="contentArea">
        <!-- Сюда будет загружаться контент -->
    </div>

    <script>
        function showContent(item) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'admin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status == 200) {
                    document.getElementById('contentArea').innerHTML = this.responseText;
                }
            };
            xhr.send('content=' + item);
        }

        function deletePhoto(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'admin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status == 200) {
                    showContent('Фото работ');
                }
            };
            xhr.send('delete=true&id=' + id);
        }

        // Функция для удаления услуги
        function deleteService(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'admin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status == 200) {
                    showContent('Услуги');
                }
            };
            xhr.send('delete_service=true&id=' + id);
        }

        // Функция для редактирования услуги
        function editService(id) {
            var serviceDiv = document.getElementById('service-' + id);
            if (!serviceDiv) return;

            document.getElementById('serviceAction').value = 'edit';
            document.getElementById('serviceId').value = id;

            // Заполним форму данными о выбранной услуге
            document.getElementById('serviceName').value = serviceDiv.getAttribute('data-name');
            document.getElementById('serviceType').value = serviceDiv.getAttribute('data-type');
            document.getElementById('serviceImagePath').value = serviceDiv.getAttribute('data-image-path');
            document.getElementById('servicePrice').value = serviceDiv.getAttribute('data-price');
        }
    </script>
</body>
</html>
