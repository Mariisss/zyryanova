-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 21 2023 г., 12:10
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zarap`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Administrators`
--

CREATE TABLE `Administrators` (
  `id` int NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Administrators`
--

INSERT INTO `Administrators` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `Appointments`
--

CREATE TABLE `Appointments` (
  `id` int NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Appointments`
--

INSERT INTO `Appointments` (`id`, `phone_number`, `appointment_date`, `name`) VALUES
(1, '', '2023-11-19', NULL),
(2, '1323123123', '2023-11-19', NULL),
(3, '123123', '2023-11-19', NULL),
(4, '123612873612', '2023-11-19', 'Тест');

-- --------------------------------------------------------

--
-- Структура таблицы `Services`
--

CREATE TABLE `Services` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('Ручной','Аппаратный','Ручной/Аппаратный','Комбинированный') DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Services`
--

INSERT INTO `Services` (`id`, `name`, `type`, `image_path`, `price`) VALUES
(1, 'Тест', 'Аппаратный', 'uploads/mmmna.webp', '500.00'),
(5, 'Тест 2', 'Комбинированный', 'uploads/gelllac.webp', '600.00'),
(6, 'тест 3', 'Ручной', 'uploads/158.jpg', '700.00'),
(7, 'Тест', 'Аппаратный', 'uploads/mmmna.webp', '500.00'),
(8, 'Тест 2', 'Комбинированный', 'uploads/gelllac.webp', '600.00'),
(9, 'тест 3', 'Ручной', 'uploads/158.jpg', '700.00');

-- --------------------------------------------------------

--
-- Структура таблицы `Works`
--

CREATE TABLE `Works` (
  `id` int NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Works`
--

INSERT INTO `Works` (`id`, `image_path`) VALUES
(1, 'uploads/1655701804_20-mykaleidoscope-ru-p-gel-lak-v-domashnikh-usloviyakh-vkontakte-20.jpg'),
(4, 'uploads/mmmna.webp'),
(5, 'uploads/158.jpg'),
(6, 'uploads/gelllac.webp');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Administrators`
--
ALTER TABLE `Administrators`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Appointments`
--
ALTER TABLE `Appointments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Works`
--
ALTER TABLE `Works`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Administrators`
--
ALTER TABLE `Administrators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `Appointments`
--
ALTER TABLE `Appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `Services`
--
ALTER TABLE `Services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `Works`
--
ALTER TABLE `Works`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
