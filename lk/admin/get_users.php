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

// Получение списка пользователей (исключая администраторов)
$stmt = $pdo->query("SELECT user_id, username, email, created_at, online_status, last_login FROM Users WHERE role_id != 1");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
