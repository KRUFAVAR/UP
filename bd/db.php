<?php
// Настройки подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uver";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    // Перенаправление на страницу 404 при ошибке подключения
    header("Location: /bd/404.php");
    exit();
}

?>
