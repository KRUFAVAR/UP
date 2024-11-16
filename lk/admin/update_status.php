<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$db = 'uver';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Проверяем, установлен ли ID пользователя и новый статус
if (isset($_POST['user_id']) && isset($_POST['online_status'])) {
    $userId = (int)$_POST['user_id'];
    $onlineStatus = (int)$_POST['online_status'];

    // Обновляем статус в базе данных
    $stmt = $pdo->prepare("UPDATE Users SET online_status = :online_status WHERE user_id = :user_id");
    $stmt->execute(['online_status' => $onlineStatus, 'user_id' => $userId]);

    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['success' => false]);
