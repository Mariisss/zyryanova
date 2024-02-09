
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Главная страница</title>
</head>
<body>
    <header>
        <div class="menu">
            <div class="logo">
                <img src="img/logo.png">    
            </div>
            <div class="navigate">
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="index.php#service">Услуги</a></li>
                    <li><a href="index.php#works">Прайс-лист</a></li>
                    <li><a href="kontakt.php">Контакты</a></li>
                </ul>
            </div>
            <div class="nomer">
                <a href="tel:89008766767">+7 (900) 876-67-67</a>
                <p>с 09:00 до 2:00</p>
            </div>
        </div>
    </header>
    <section class="zapis">
        <div class="zapis-flex">
            <div class="zapis-zaglav">
                <h2>Маникюр с покрытием за 1350 рублей с гарантией 2 недели</h2>
            </div>
            <div class="zapis-info">
                <p>Цены ниже рыночных</p>
                <p>Снятие покрытия в подарок!</p>
                <p>Вежливые и внимательные мастера</p>
            </div>
            <div class="zapis-forma">
                <h3>Оставьте заявку сейчас и получите скидку 10% на ВСЕ виды маникюра и педикюра!</h3>
                            <form id="appointmentForm">
                    <input type="text" id="nameInput" placeholder="Ваше имя" required>
                    <input type="tel" id="phoneInput" placeholder="+7 (900) 800-89-89" required>
                    <button type="submit">Отправить</button>
                </form>
                <div id="successMessage" style="display:none;">
                    Ваша заявка успешно отправлена. В ближайшее время с вами свяжется администратор.
                </div>
            </div>
        </div>
    </section>
    <script>  
document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var name = document.getElementById('nameInput').value; // Получаем имя
    var phone = document.getElementById('phoneInput').value; // Получаем номер телефона

    // AJAX запрос для отправки данных на сервер
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_appointment.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Формируем данные для отправки, включая и имя, и номер телефона
    var data = "name=" + encodeURIComponent(name) + "&phone=" + encodeURIComponent(phone);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('appointmentForm').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';
        }
    }
    xhr.send(data);
});
</script>

    <section class="kontakt">
        <div class="kont">
            <div class="kleft">
                <h1>Контакты</h1>
                <div class="kontabout">
                    <div class="kabout1">
                        <p><b>Адрес</b></p>
                        <p>г. Екатеринбург, Розы Люксембург 12, оф 501</p>
                        <a href="tel:88009898787">+7 (800) 989-87-87</a>
                    </div>
                    <div class="kabout2">
                        <p><b>Email:</b> example@ex.com</p>
                    </div>
                </div>
            </div>
            <div class="rleft">
            <div style="position:relative;overflow:hidden;">
            <a href="https://yandex.ru/maps?utm_medium=mapframe&utm_source=maps" 
            style="color:#eee;font-size:12px;position:absolute;top:0px;">Яндекс Карты</a>
            <a href="https://yandex.ru/maps/?from=mapframe&ll=60.131616%2C57.141166&mode=usermaps&source=mapframe&um=constructor%3A1360acf31b5779179247ea8e5d49d175f18ef907fa3526bed1088a6f173a929e&utm_medium=mapframe&utm_source=maps&z=8" 
            style="color:#eee;font-size:12px;position:absolute;top:14px;">Яндекс Карты — транспорт, навигация, поиск мест</a>
            <iframe src="https://yandex.ru/map-widget/v1/?from=mapframe&ll=60.131616%2C57.141166&mode=usermaps&source=mapframe&um=constructor%3A1360acf31b5779179247ea8e5d49d175f18ef907fa3526bed1088a6f173a929e&utm_source=mapframe&z=8" 
                width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
            </div>
        </div>
    </section>

    <section class="works">
        <div class="works-master">
            <h1>Фото работ наших мастеров</h1>
            <p>Все мастера с опытом работы более 5 лет</p>
            <div class="work-images">
                <?php
                // Здесь вставьте код, который выводит изображения из таблицы Works
                $servername = "127.0.0.1";
                $username = "root";
                $password = "root";
                $dbname = "zarap";
                $port = 3306;

                $conn = new mysqli($servername, $username, $password, $dbname, $port);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT * FROM Works");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="work-image">
                                <img src="' . $row["image_path"] . '" alt="Работа мастера">
                              </div>';
                    }
                } else {
                    echo "Фотографий нет";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <section class="about-min">
        <div class="about">
            <h1>Почему 90% клиентов работают с нами минимум 1,5 года</h1>
            <div class="block-info">
                <div class="info">
                    <h4>Стерильность</h4>
                    <p>Инструменты для маникюра проходят три этапа стерилизации:</p>
                    <p>1) Предстерилизационная обработка - дезинфицируем инструменты средством Эстилодез</p>
                    <p>2) Стерилизуем инструменты гласперленовым стерилизатором</p>
                    <p>3) Храним инструменты в ультрафиолетовых шкафах, обеспечивая стерильность и предохраняя инструменты от попадания бактерий</p>
                </div>
                <div class="info">
                    <h4>Опытные мастера</h4>
                    <p>В нашей студии работает технолог с 20-летним стажем.</p>
                    <p>Все мастера по маникюру и педикюру проходят серьезную стажировку прежде чем приступить к работе.</p>
                </div>
                <div class="info">
                    <h4>Профессиональная косметика</h4>
                    <p>Мы используем только высококачественную косметику американского производства.
                        Бренд Be natural - средства для размягчения и удаления кутикулы Cuticle Eliminator и натоптышей Callus Eliminator.
                        Гель-лаки Shellac – марка Creative Nail Design.
                        Гель-лаки Gelish - Компания Hand & Nail Harmony.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="otzov">
        <div class="otzovi">
            <h1>Отзывы клиентов</h1>
            <p>Благодарности постоянных клиентов</p>
            <div class="block-otzova">
                <div class="otz">
                    <p>Третий раз посещаю ногтевой студию в данном салоне. Дария лучшая из тех что я знаю!!! Рекомендую 👍💅</p>
                    <p><b>Кристина Панова</b></p>
                </div>
                <div class="otz">
                    <p>Третий раз посещаю ногтевой студию в данном салоне. Довольна, нет слов. Мастер Екатерина лучшая из тех что я знаю!!! Рекомендую 👍💅</p>
                    <p><b>Кристина Панова</b></p>
                </div>
                <div class="otz">
                    <p>Третий раз посещаю ногтевой студию в данном салоне. Довольна, нет слов. Мастер Екатерина лучшая из тех что я знаю!!! Рекомендую 👍💅</p>
                    <p><b>Кристина Панова</b></p>
                </div>
                <div class="otz">
                    <p>Третий раз посещаю ногтевой студию в данном салоне. Довольна, нет слов. Мастер Екатерина лучшая из тех что я знаю!!! Рекомендую 👍💅</p>
                    <p><b>Кристина Панова</b></p>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>