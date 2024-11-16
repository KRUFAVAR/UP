<?php
session_start(); // Запускаем сессию

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

// Проверка, если форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Проверка, заполнены ли поля
    if (empty($username) || empty($password)) {
        echo "Пожалуйста, заполните все поля.";
    } else {
        try {
            // Получаем пользователя по имени
            $stmt = $pdo->prepare("SELECT user_id, password, role_id FROM Users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Проверяем пароль
                if (password_verify($password, $user['password'])) {
                    // Успешная авторизация
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role_id'] = $user['role_id']; // Сохраняем роль в сессии

                    // Обновление времени последнего входа и статуса
                    $updateStmt = $pdo->prepare("UPDATE Users SET last_login = NOW(), online_status = 1 WHERE user_id = :user_id");
                    $updateStmt->execute(['user_id' => $user['user_id']]);

                    // Перенаправление в зависимости от роли
                    if ($user['role_id'] == 2) {
                        header("Location: profile/profile.php"); // Перенаправление на профиль пользователя
                    } elseif ($user['role_id'] == 1) {
                        header("Location: admin/index.php"); // Перенаправление на админ-панель
                    }
                    exit();
                } else {
                    echo "Неверный пароль.";
                }
            } else {
                echo "Пользователь не найден.";
            }
        } catch (PDOException $e) {
            echo "Ошибка базы данных: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"> <!-- Подключение CSS -->
    <title>Авторизация</title>
</head>
<body>
    <h1>Авторизация</h1>
    <form method="POST" action="">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
</body>
</html>
