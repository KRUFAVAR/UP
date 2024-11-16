<?php
session_start();
include '../bd/db.php'; // Подключаем файл с подключением к базе данных

// Подключение к базе данных (уже выполнено в db.php)
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

// Функция для обработки регистрации
function registerUser($pdo, $username, $email, $password) {
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $role_id = 2; // Обычный пользователь

    $stmt = $pdo->prepare("INSERT INTO Users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $passwordHash, $role_id])) {
        echo "Регистрация прошла успешно";
    } else {
        echo "Ошибка при регистрации.";
    }
}

// Функция для обработки авторизации
function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT user_id, password, role_id FROM Users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Успешная авторизация
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role_id'] = $user['role_id'];

        // Обновление статуса и времени последнего входа
        $updateStmt = $pdo->prepare("UPDATE Users SET last_login = NOW(), online_status = 1 WHERE user_id = :user_id");
        $updateStmt->execute(['user_id' => $user['user_id']]);

        // Перенаправление в зависимости от роли
        if ($user['role_id'] == 2) {
            header("Location: ../lk/profile/profile.php"); // Обычный пользователь
        } else {
            header("Location: ../lk/admin/index.php"); // Администратор
        }
        exit();
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
}

// Обработка форм
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (isset($_POST['register'])) {
        if (!empty($username) && !empty($email) && !empty($password)) {
            registerUser($pdo, $username, $email, $password);
            header("Location: ../back/index.html")   ; // Укажите путь к странице авторизации
        exit();
        } else {
            echo "Пожалуйста, заполните все поля для регистрации.";
        }
    } elseif (isset($_POST['login'])) {
        if (!empty($username) && !empty($password)) {
            loginUser($pdo, $username, $password);
        } else {
            echo "Пожалуйста, заполните все поля для авторизации.";
        }
    }
}
?>

