<?php
session_start();

// Подключение к базе данных
$host = 'localhost'; // Ваш хост
$db = 'uver'; // Имя вашей базы данных
$user = 'root'; // Имя пользователя базы данных
$pass = ''; // Пароль базы данных

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Проверка, если пользователь авторизован
if (isset($_SESSION['user_id'])) {
    // Обновление статуса пользователя на офлайн
    $updateStmt = $pdo->prepare("UPDATE Users SET online_status = 0 WHERE user_id = :user_id");
    $updateStmt->execute(['user_id' => $_SESSION['user_id']]);
}

// Удаляем сессию
session_destroy();

// Перенаправление на страницу логина
header("Location: ../../back/index.html");
exit();
?>
